<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\EventAbstract;
use App\Models\EventAbstractHistory;

use App\Models\EventTopic;

use App\Models\EventSCommittee;

use App\Models\EventFullPaperHistory;
use App\Models\EventFullPaper;
use App\Models\PaperComments;

use App\Models\Notifications;
use App\Models\Events;
use App\Models\Users;

use App\Models\EventImportantDate;
use Input;
use Storage;
use Config;

use Session;
use Auth;

class RevisionController extends Controller
{
    //
    public function abstracts()
    {
    	$abstracts = EventAbstract::where('reviewer_id', Auth::user()->user_id)->where('status','<=',1)->get();
    	return View('revision.abstracts.index')->with(array(
    		'abstracts' => $abstracts
    	));
        // ->where('expire', '>', date("Y-m-d"))
    }

    public function abstractx($id)
    {
    	$abstract = EventAbstract::where('abstract_id',$id)->first();
    	$topic = EventTopic::where('topic_id',$abstract['topic_id'])->first();
    	$scs = EventSCommittee::where('event_id', $abstract->event_id)->get();
    	return view('revision.abstracts.abstract')->with(array(
    		'abstract' => $abstract,
    		'topic' => $topic->title_en,
    		'scs'	=> $scs
    	));
    }

    public function busy_abstract($id,$reason)
    {
    	$user = Auth::user()->user_id;
    	$isReviewer = EventAbstract::where('reviewer_id', $user)->where('abstract_id', $id)->first();
    	if($isReviewer == true)
    	{
    		$reject = EventAbstract::where('abstract_id', $id)->update(array(
    			'status' 		=> 0,
    			'reviewer_id' 	=> NULL,
    			'expire'		=> NULL
    		));
            $history = EventAbstractHistory::create([
                'abstract_id' => $id,
                'reviewer_id' => $user,
                'title'     => 'Rejected',
                'expire' => NULL,
                'comment'     => 'Reject Reason: '.str_replace('-', ' ', $reason)
            ]);
    	}
    	Session::flash('status','Abstract revision request refused.');
    	return redirect('/revision/abstract');
    }

    public function reject_abstract($id)
    {
    	$user = Auth::user()->user_id;
    	$isReviewer = EventAbstract::where('reviewer_id', $user)->where('abstract_id', $id)->first();
    	if($isReviewer == true)
    	{
    		$reject = EventAbstract::where('abstract_id', $id)->update(array(
    			'status' 		=> 9,
    			'reviewer_id' 	=> NULL,
    			'expire'		=> NULL
    		));
    	}
        $ab = EventAbstract::where('abstract_id', $id)->first();

        $mail = curl_init(url('mail_send?event='.$ab['event_id'].'&abstract='.$id.'&paper=&template=8'.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);
        $ev = Events::where('event_id',$ab['event_id'])->first();
        $notification = Notifications::create(array(
            'title' => 'Abstract Rejected',
            'description' => 'Your Abstract Was Rejected Please Review Abstract Guidlines And Then Upload Your Abstract Again.<br><br>If you think this is wrong, please contact us at the following email address: <a href="mailto:'.$ev['email'].'?Subject=Abstract%20'.$id.'%Rejection%20Complaint">'.$ev['email'].'</a>',
            'user_id' => $ab['author_id'],
            'color' => 'green',
            'type' => 'abstract-rejected',
            'icon' => 'file',
            'timeout' => 25000,
            'url' => '/abstract/status/'.$id,
            'status' => 'info'
        ));
    	Session::flash('status','Abstract was rejected.');
    	return redirect('/revision/abstract');
    }

    public function accept_abstract($id)
    {
    	$user = Auth::user()->user_id;
    	$isReviewer = EventAbstract::where('reviewer_id', $user)->where('abstract_id', $id)->first();
    	if($isReviewer == true)
    	{
    		$accept = EventAbstract::where('abstract_id', $id)->update(array('status' => 3));
    	}
        $ab = EventAbstract::where('abstract_id', $id)->first();
        $mail = curl_init(url('mail_send?event='.$ab['event_id'].'&abstract='.$id.'&paper=&template=7'.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);
        $close = EventImportantDate::where('event_id', $ab['event_id'])->where('event_date_type_id',4)->first();
        $notification = Notifications::create(array(
            'title' => 'Abstract Accepted',
            'description' => 'Your Abstract Was Accepted Please Upload Your Full Paper Before Date: '.date('d-m-Y',strtotime($close['to_date'])),
            'user_id' => $ab['author_id'],
            'color' => 'green',
            'type' => 'paper-upload',
            'icon' => 'file',
            'timeout' => 25000,
            'url' => '/abstract/status/'.$id,
            'status' => 'info'
        ));
    	Session::flash('status','Abstract was accepted.');
    	return redirect('/revision/abstract');
    }

    public function papers()
    {
    	$papers = EventFullPaperHistory::where('reviewer_id',Auth::user()->user_id)->where('result',0)->get();

    	return view('revision.papers.index')->with(array(
    		'papers' 		=> $papers
    	));
    }

    public function remove_paper_reviewer($paper_id, $reviewer_id, $rev)
    {
        switch($rev)
        {
            case 'first_reviewer':
                $remove = EventFullPaper::where('paper_id', $paper_id)->where('first_reviewer', $reviewer_id)->update(array(
                    'first_reviewer'    => NULL,
                    'expire_first'      => NULL,
                    'mark_first'        => NULL,
                    'result_first'      => NULL
                ));
            break;

            case 'second_reviewer':
                $remove = EventFullPaper::where('paper_id', $paper_id)->where('second_reviewer', $reviewer_id)->update(array(
                    'second_reviewer'    => NULL,
                    'expire_second'      => NULL,
                    'mark_second'        => NULL,
                    'result_second'      => NULL
                ));
            break;

            case 'third_reviewer':
                $remove = EventFullPaper::where('paper_id', $paper_id)->where('third_reviewer', $reviewer_id)->update(array(
                    'third_reviewer'    => NULL,
                    'expire_third'      => NULL,
                    'mark_third'        => NULL,
                    'result_third'      => NULL
                ));
            break;
        }
        $paper = EventFullPaper::where('paper_id', $paper_id)->first();
        if($paper->second_reviewer == NULL)
        {
            $paperStatus = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'status' => 1
            ));
            $abstractStatus = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array(
                'status' => 5
            ));
        }
        Session::flash('status','Revision request refused.!');
        return redirect('/revision/paper');
    }

    public function paper($id)
    {
        $paper = EventFullPaperHistory::where('id',$id)->first();
        $user = Auth::user()->user_id;
        if($paper->reviewer_id != $user)
        {
        	return redirect('/revision/paper');
        }
        return view('revision.papers.paper')->with(array(
            'paper'     => $paper
        ));
    }

    public function paper_result(Request $request, $paper_id, $rev)
    {
    	$data = $request->all();
    	$user = Auth::user()->user_id;
    	switch($data['submit'])
    	{
    		case 'APPROVE': 
    			switch($rev){
    				case 'first_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('first_reviewer', $user)->update(array(
		    				'result_first' 	=> 2,
		    				'mark_first'	=> @$data['mark'] 
		    			));
    				break;
    				case 'second_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('second_reviewer', $user)->update(array(
		    				'result_second' => 2,
		    				'mark_second'	=> @$data['mark'] 
		    			));
    				break;
    				case 'third_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('third_reviewer', $user)->update(array(
		    				'result_third' 	=> 2,
		    				'mark_third'	=> @$data['mark'] 
		    			));
    				break;
    			}
    		break;
    		case 'REJECT': 
    			switch($rev){
    				case 'first_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('first_reviewer', $user)->update(array(
		    				'result_first' 	=> 1,
		    				'mark_first'	=> @$data['mark'] 
		    			));
    				break;
    				case 'second_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('second_reviewer', $user)->update(array(
		    				'result_second' => 1,
		    				'mark_second'	=> @$data['mark'] 
		    			));
    				break;
    				case 'third_reviewer':
    					$approve = EventFullPaper::where('paper_id',$paper_id)->where('third_reviewer', $user)->update(array(
		    				'result_third' 	=> 1,
		    				'mark_third'	=> @$data['mark'] 
		    			));
    				break;
    			}
    		break;
    	}
    	$paper = EventFullPaper::where('paper_id', $paper_id)->first();
    	$accept = 0;
    	$reviewed = 0;
    	$results = null;
    	if($paper->result_first != NULL)
    	{
    		$reviewed ++;
    		if($paper->result_first == 2){
                $accept++;
            }
    	}
    	if($paper->result_second != NULL)
    	{
    		$reviewed ++;
    		if($paper->result_second == 2){
                $accept++;
            }
    	}
    	if($paper->result_third != NULL)
    	{
    		$reviewed ++;
    		if($paper->result_third == 2){
                $accept++;
            }
    	}

        if($accept >= 2){
            $abstract = EventAbstract::where('abstract_id', $paper->abstract_id)->update(array(
                'status' => 7
            ));
            $accepted = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'status' => 3
            ));
        }elseif($accept == 1 && $reviewed == 2){

        }elseif($reviewed >= 2 && $accept < 2){
            $abstract = EventAbstract::where('abstract_id', $paper->abstract_id)->update(array(
                'status' => 8
            ));
            $accepted = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'status' => 4
            ));
        }



        Session::flash('status','Paper result recorded.!');
        return redirect('/revision/paper/'.$paper_id.'/view');
    }
    public function paper_status(Request $request, $id){
        $req = $id;
        $update = EventFullPaperHistory::where('id',$id)->update([
            'result' => $request['result'],
            'comments' => $request['comments'],
            'extras' => $request['extras']
        ]);
        $pa = EventFullPaper::where('paper_id',$request['paper_id'])->first();
        if ($request->hasFile('evaluation_sheet')  &&  $request->file('evaluation_sheet')->isValid()) {
            $coverImg = $request->file('evaluation_sheet');
            $destinationPath = 'uploads/fullpapers/'.$request['event_id'].'/'.$request['paper_id'].'/'.$req.'/'; // upload path
            $extension = $coverImg->getClientOriginalExtension(); // getting image extension
            $fileName = 'evaluation_sheet_'.$req.'.'.$extension;//$extension; // renameing image
            //$coverImg->move($destinationPath, $fileName); // uploading file to given path
            $update = EventFullPaperHistory::where('id',$id)->update([
                'evaluation_sheet' => $fileName
            ]);
            Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('evaluation_sheet')->getRealPath()));
          // sending back with message
        }
        if($request['result'] == 1 || $request['result'] == 2){$template = 10;}elseif($request['result']==3){$template = 11;}
        $mail = curl_init(url('mail_send?event='.$request['event_id'].'&abstract='.$pa['abstract_id'].'&paper='.$request['paper_id'].'=&template='.$template.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);
        Session::flash('status','Result Was Submitted, Thank You!.');
        return redirect('/revision/paper');

    }
}
