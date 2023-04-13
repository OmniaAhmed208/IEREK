<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventAbstract;
use App\Models\EventAbstractHistory;

use App\Models\EventFullPaper;

use App\Models\Events;

use App\Models\Users;

use App\Models\EventTopic;

use App\Models\EventAdmins;

use App\Models\Notifications;

use App\Models\EventSCommittee;

use App\Models\EventFullPaperHistory;

use App\Models\EventImportantDate;

use App\Models\EventFullPaperReviewers;

use App\Models\PaperComments;

use App\Models\MailTemplates;
use App\Models\EventAttendance;

use Mail;

use Input;
use Storage;
use Config;

use Auth;

use Session;

class ConferenceSubmissionController extends Controller
{
    //

    public function index($event_id)
    {
    	$event = Events::where('event_id', $event_id)->first();
    	$abstracts = EventAbstract::where('event_id', $event_id)->get();
    	$papers = EventFullPaper::where('event_id', $event_id)->get();
    	return view('admin.events.conference.submission.index')->with(array(
    		'event' => $event['title_en'],
    		'event_id' => $event['event_id'],
    		'abstracts' => $abstracts,
    		'papers' => $papers
    	));
    }

    public function abstractx($id)
    {
    	$abstract = EventAbstract::where('abstract_id',$id)->first();
    	$topic = EventTopic::where('topic_id',$abstract['topic_id'])->first();
    	$scs = Users::where('user_type_id',1)->get();
        $history = EventAbstractHistory::where('abstract_id',$id)->get();
    	return view('admin.events.conference.submission.abstract')->with(array(
    		'abstract' => $abstract,
    		'topic' => $topic->title_en,
    		'scs'	=> $scs,
            'history' => $history
    	));
    }

    public function abstract_reviewer(Request $request)
    {
    	$data = $request->all();
    	$abstract = EventAbstract::where('abstract_id', $data['abstract_id'])->update([
    		'reviewer_id' => $data['reviewer_id'],
            'expire'      => $data['expire']
    	]);
        $sc_ids = Users::where('user_id',$data['reviewer_id'])->first();
        $sc_id = $sc_ids->user_id;
        $history = EventAbstractHistory::create([
            'abstract_id' => $data['abstract_id'],
            'reviewer_id' => $sc_id,
            'updated_at' => $data['expire'],
            'title'     => 'Assigned',
            'comment'     => 'Assigned by '.Auth::user()->first_name.' '.Auth::user()->last_name
        ]);

        $notification = Notifications::create(array(
            'title' => 'Abstract Revision Request',
            'description' => 'You Have New Abstract Revision Request',
            'user_id' => $sc_id,
            'color' => 'green',
            'type' => 'abstract-revision',
            'icon' => 'file',
            'timeout' => 25000,
            'url' => '/revision/abstract/'.$data['abstract_id'].'/view',
            'status' => 'info'
        ));
    	Session::flash('success', 'Reviewer assigned successfully');
    	return redirect('/admin/events/conference/abstract/'.$data['abstract_id']);
    }

    public function abstract_accept_as(Request $request)
    {
        $data = $request->all();
        $abstract = EventAbstract::where('abstract_id', $data['abstract_id'])->update([
            'reviewer_id' => $data['reviewer_id'],
            'status' => 3
        ]);
        $sc_ids = Users::where('user_id',$data['reviewer_id'])->first();
        // dd($sc_ids);
        $sc_id = $sc_ids->user_id;
        $history = EventAbstractHistory::create([
            'abstract_id' => $data['abstract_id'],
            'reviewer_id' => $sc_id,
            'title'     => 'Accepted as',
            'comment'     => 'Accepted on behave by '.Auth::user()->first_name.' '.Auth::user()->last_name
        ]);
        $ab = EventAbstract::where('abstract_id', $data['abstract_id'])->first();
        EventAttendance::where('event_id', $ab['event_id'])
                ->where('user_id', $ab['author_id'])
                ->update(array('event_attendance_type_id' => 3));
        $close = EventImportantDate::where('event_id', $ab['event_id'])->where('event_date_type_id',4)->first();
        $mail = curl_init(url('mail_send?event='.$ab['event_id'].'&abstract='.$data['abstract_id'].'&paper=&template=7'.'&user_id='.$ab['author_id']));
        curl_exec($mail);
        $notification = Notifications::create(array(
            'title' => 'Abstract Accepted',
            'description' => 'Your Abstract Was Accepted Please Upload Your Full Paper Before Date: '.date('d-m-Y',strtotime($close['to_date'])),
            'user_id' => $ab['author_id'],
            'color' => 'green',
            'type' => 'paper-upload',
            'icon' => 'file',
            'timeout' => 25000,
            'url' => '/abstract/status/'.$data['abstract_id'],
            'status' => 'info'
        ));
        Session::flash('success', 'Abstract accepted successfully');
        return redirect('/admin/events/conference/abstract/'.$data['abstract_id']);
    }

    public function abstract_approve($id)
    {
    	$abstract = EventAbstract::where('abstract_id', $id)->first();
    	$event_id = $abstract->event_id;

    	EventAbstract::where('abstract_id', $id)->update(array('status' => 1));

         EventAttendance::where('event_id',$event_id)
        ->where('user_id', $abstract['author_id'])
        ->update(array('event_attendance_type_id' => 3));

        Session::flash('status','<b>Info</b><br><br>Abstract accepted successfully.');
        $rdir = '/admin/events/conference/submission/'.$event_id;
        $mail = curl_init(url('mail_send?event='.$abstract['event_id'].'&abstract='.$abstract['abstract_id'].'&paper=&template=6'.'&user_id='.$abstract['author_id']));
        curl_exec($mail);
        Session::flash('redirect', $rdir);
        
        return redirect('/admin/events/conference/abstract/'.$id);

    }

    public function abstract_reject($id)
    {
    	$abstract = EventAbstract::where('abstract_id', $id)->first();
    	$event_id = $abstract->event_id;
    	$abstract = EventAbstract::where('abstract_id', $id)->update(array('status' => 9));
        Session::flash('status','<b>Info</b><br><br>Abstract rejected successfully.');
        $rdir = '/admin/events/conference/submission/'.$event_id;
        $mail = curl_init(url('mail_send?event='.$abstract['event_id'].'&abstract='.$abstract['abstract_id'].'&paper=&template=8'.'&user_id='.$abstract['author_id']));
        curl_exec($mail);
    	Session::flash('redirect', $rdir);
//    	return redirect('/admin/events/conference/abstract/'.$id);

    }

    public function reviewer_edition(Request $request, $id){
        $data = $request->all();
        if ($request->hasFile('reviewer_edition')  &&  $request->file('reviewer_edition')->isValid()) {
            $coverImg = $request->file('reviewer_edition');
            $destinationPath = 'uploads/conferences/'.$request['event_id'].'/'.$request['paper_id']; // upload path
            $extension = $coverImg->getClientOriginalExtension(); // getting image extension
            $fileName = '/reviewer_edition.'.'docx';//$extension; // renameing image
            //$coverImg->move($destinationPath, $fileName); // uploading file to given path
            Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('reviewer_edition')->getRealPath()));
          // sending back with message
        }

        Session::flash('status','Reviewer Edition Uploaded Successfully.!');

        return redirect('/admin/events/conference/paper/'.$id);
    }

    public function final_edition(Request $request, $id){
        $data = $request->all();
        if ($request->hasFile('final_edition')  &&  $request->file('final_edition')->isValid()) {
            $coverImg = $request->file('final_edition');
            $destinationPath = 'uploads/fullpapers/'.$request['event_id'].'/'.$request['paper_id'];; // upload path
            $extension = $coverImg->getClientOriginalExtension(); // getting image extension
            $fileName = '/final_edition.'.'docx';//$extension; // renameing image
            //$coverImg->move($destinationPath, $fileName); // uploading file to given path
            Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('final_edition')->getRealPath()));
          // sending back with message
        }

        Session::flash('status','Final Edition Uploaded Successfully.!');

        return redirect('/admin/events/conference/paper/'.$id);
    }

    public function paper_approve($id)
    {
    	$paper = EventFullPaper::where('paper_id', $id)->first();
    	 EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 5));
    	 EventFullPaper::where('paper_id', $id)->update(array('status' => 1));
        $mail = curl_init(url('mail_send?event='.$paper['event_id'].'&abstract='.$paper['abstract_id'].'&paper='.$id.'&template=9'.'&user_id='.$paper['author_id']));
        curl_exec($mail);
    	Session::flash('status','Paper approved successfully.');
    	// Session::flash('close','close');
    	return redirect('/admin/events/conference/paper/'.$id);

    }

    public function paper_reject($id)
    {
    	$paper = EventFullPaper::where('paper_id', $id)->first();
    	EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 8));
    	EventFullPaper::where('paper_id', $id)->update(array('status' => 4));
        $mail = curl_init(url('mail_send?event='.$paper['event_id'].'&abstract='.$paper['abstract_id'].'&paper='.$id.'&template=11'.'&user_id='.$paper['author_id']));
        curl_exec($mail);
    	Session::flash('status','Paper approved successfully.');
    	Session::flash('close','close');
    	return redirect('/admin/events/conference/submission/'.$event_id);

    }

    public function paper_status(Request $request, $id){
        $paper = EventFullPaper::where('paper_id', $id)->first();
        $abstract = EventAbstract::where('abstract_id', $paper['abstract_id'])->first();
        $template = null;
        if($request['status'] == 3){
            $abstractu = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 7));
            $paperu = EventFullPaper::where('paper_id', $id)->update(array('status' => 3));
            $template = 10;
        }elseif($request['status'] == 4){
            $abstractu = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 8));
            $paperu = EventFullPaper::where('paper_id', $id)->update(array('status' => 4));
            $template = 11;
        }elseif($request['status'] == 0){
            $abstractu = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 4));
            $paperu = EventFullPaper::where('paper_id', $id)->update(array('status' => 0));
        }
        $notes = EventFullPaper::where('paper_id',$id)->update([
            'notes' => $request['notes']
            ]);
        $mail = curl_init(url('mail_send?event='.$paper['event_id'].'&abstract='.$paper['abstract_id'].'&paper='.$id.'&template='.$template.'&user_id='.$paper['author_id']));
        if($template != null){curl_exec($mail);}
        Session::flash('status','Paper Result Was Changed Successfully.!');
        return redirect('/admin/events/conference/paper/'.$id);
    }

    public function paper($id)
    {
        $paper = EventFullPaper::where('paper_id',$id)->first();
        $paperReviewers = [0,1];
        if($paper->first_reviewer != NULL){
            array_push($paperReviewers , @$paper->first_reviewer);
        }
        if($paper->second_reviewer != NULL){
            array_push($paperReviewers , @$paper->second_reviewer);
        }
        if($paper->third_reviewer != NULL){
            array_push($paperReviewers , @$paper->third_reviewer);
        }
        $abstract_id = $paper['abstract_id'];
        $abstract = EventAbstract::where('abstract_id',$abstract_id)->first();
        $topic = EventTopic::where('topic_id',$abstract['topic_id'])->first();
        $scs = EventSCommittee::where('event_id', $abstract->event_id)
                                ->whereNotIn('user_id',$paperReviewers)->get();
        $scxs = EventSCommittee::where('event_id', $abstract->event_id)->get();

        $reviewers = EventFullPaperHistory::where('paper_id', $id)->get();
        $comments = PaperComments::where('paper_id', $paper->paper_id)->get();
        return view('admin.events.conference.submission.paper')->with(array(
            'abstract'  => $abstract,
            'download_type' => EventAbstract::fullpaper_type,
            'paper'     => $paper,
            'topic'     => $topic->title_en,
            'reviewers' => $reviewers,
            'scs'       => $scs,
            'scxs'      => $scxs,
            'comments'  => $comments
        ));
    }

    public function add_reviewer(Request $request, $id){
        if($request['reviewer_id'] == 0)
        {
            Session::flash('status','Please choose reviewer.!');
            return redirect('/admin/events/conference/paper/'.$id);
        }else{
            $paper = EventFullPaper::where('paper_id', $id)->first();
            $paperData = EventFullPaper::where('paper_id', $id)->first();
            $abstract = EventAbstract::where('abstract_id', $paper['abstract_id'])->first();
            $abstractData = EventAbstract::where('abstract_id', $paper['abstract_id'])->first();
            $abstract = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array('status' => 6));
            $paper = EventFullPaper::where('paper_id', $id)->update(array('status' => 2));
            $event = Events::where('event_id', $paperData['event_id'])->first();
            $new = EventFullPaperHistory::create([
                'reviewer_id' => $request['reviewer_id'],
                'paper_id' => $id,
                'expire' => $request['expire']
            ]);

            $notification = Notifications::create(array(
                'title' => 'Paper Revision Request',
                'description' => 'Your Have Paper Revision Request, Due Date: '.date('d-m-Y',strtotime($request['expire'])),
                'user_id' => $request['reviewer_id'],
                'color' => 'green',
                'type' => 'paper-revision',
                'icon' => 'file',
                'timeout' => 25000,
                'url' => '/revision/paper/'.$new->id.'/view',
                'status' => 'info'
            ));

           
               $paper_id = $paperData['paper_id'];
            if($request['email'] == 1){
                $user = Users::where('user_id' , $request['reviewer_id'])->first();
                $paper = EventFullPaper::where('paper_id', $id)->first();
//                $template = MailTemplates::where('mail_id',16)->first();
                $title = "Request paper review";
                $email = $user['email'];
                $name = $user['first_name']." ".$user['last_name'];
                //$content = $template['message'];
                //$newid = $new->id;
                $event_id = $paper['event_id'];
                $from = 'info@ierek-scholar.org';
                Mail::send('admin.mail.paper', ['title' => $title,'event_id' => $event_id,'event_name' => $event['title_en'],'paper_code' => $paperData['code'],'name' => $name,'expire_date' => $request['expire'],'abstract_content' => $abstractData['abstract'],'paper_id' => $paper_id ], function ($message) use ($email,$from)
                {
                    $message->from($from, 'IEREK');

                    $message->to($email);

                    $message->subject('IEREK - Knowledge & Research Enrichment');

                });
            }

            Session::flash('status','Reviewer Assigned Successfully.!');
            return redirect('/admin/events/conference/paper/'.$id);
        }
    }

    public function paper_reviewer(Request $request,$paper_id)
    {
        $data = $request->all();
        if($data['reviewer_id'] == 0)
        {
            Session::flash('status','Please choose reviewer.!');
            return redirect('/admin/events/conference/paper/'.$paper_id);
        }
        $paper = EventFullPaper::where('paper_id', $paper_id)->first();
        if($paper->first_reviewer == NULL){
            $assign = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'first_reviewer' => $data['reviewer_id'],
                'expire_first'   => $data['expire']
            ));
        }
        elseif($paper->second_reviewer == NULL)
        {
            $assign = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'second_reviewer'  => $data['reviewer_id'],
                'expire_second'    => $data['expire']
            ));
            $paperStatus = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'status' => 2
            ));
            $abstractStatus = EventAbstract::where('abstract_id', $paper['abstract_id'])->update(array(
                'status' => 6
            ));
        }
        elseif($paper->third_reviewer == NULL)
        {
            $assign = EventFullPaper::where('paper_id', $paper_id)->update(array(
                'third_reviewer'  => $data['reviewer_id'],
                'expire_third'    => $data['expire']
            ));
        }
        Session::flash('status','Reviewer assigned successfully.!');
        return redirect('/admin/events/conference/paper/'.$paper_id);
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
                    'result_first'     => NULL
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
                    'result_third'     => NULL
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
        Session::flash('status','Reviewer removed successfully.!');
        return redirect('/admin/events/conference/paper/'.$paper_id);
    }

    public function review($id){
        $paper = EventFullPaperHistory::where('id',$id)->first();
        $user = Auth::user()->user_id;
        return view('admin.events.conference.submission.review')->with(array(
            'paper'     => $paper
        ));
    }
}
