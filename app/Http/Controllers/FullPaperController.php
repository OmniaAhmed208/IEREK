<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Events;
use App\Models\Users;
use App\Models\EventAttendance;
use App\Models\EventTopic;
use App\Models\EventAbstract;
use App\Models\EventFullPaper;
use App\Models\PaperComments;
use App\Models\EventAdmins;
use App\Models\Notifications;
use App\Models\Coauthors;
use Response;
use Storage;
use Auth;
use Validator;
use Session;

class FullPaperController extends Controller
{

    public function submit(Request $request, $id)
    {
    	$data = $request->all();
    	$event = Events::where('event_id', $data['event_id'])->first();
    	$code = strtoupper(substr($event->title_en, 0,3)).'-'.strtoupper(substr(md5(microtime()),0,4)).'-P';
        $validator = Validator::make($request->all(), [
            'fullfile' => 'max:51200|min:0|mimes:doc,docx',
            'blindfile' => 'max:51200|min:0|mimes:doc,docx'
        ]);
        if ($validator->fails())
        {
            $dd = array(
                'success' => false,
                'errs' => $validator->getMessageBag()->toArray()
            );
            $err = 101;
            return $err;
        }else{
        	if ($request->hasFile('fullfile')  &&  $request->file('fullfile')->isValid()) {
                $fullpaper = $request->file('fullfile');
                $destinationPath = EventAbstract::fullpaper_folder. "/". $data['event_id'] . "/"; // upload path
                $extension = $fullpaper->getClientOriginalExtension(); // getting image extension
                $fileName = $code.'.'.$extension;//$extension; // renameing image
                //$paper->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('secured')->put($destinationPath.$fileName ,file_get_contents($request->file('fullfile')->getRealPath()));
              // sending back with message
            }else{
            	$fileName = '';
            }
            
            	if ($request->hasFile('blindfile')  &&  $request->file('blindfile')->isValid()) {
                $blindpaper = $request->file('blindfile');
                $blinddestinationPath = EventAbstract::blindpaper_folder. "/". $data['event_id'] . "/"; // upload path
                $blindextension = $blindpaper->getClientOriginalExtension(); // getting image extension
                $blindfileName = $code.'.'.$blindextension;//$extension; // renameing image
                //$paper->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('secured')->put($blinddestinationPath.$blindfileName ,file_get_contents($request->file('blindfile')->getRealPath()));
              // sending back with message
            }else{
            	$blindfileName = '';
            }
            
            $abstract = EventAbstract::where('abstract_id', $id)->update(array('status' => 4));
            $toAuthor = EventAttendance::where('event_id',$event->event_id)->where('user_id',auth()->user()->user_id)->update([
                'event_attendance_type_id' => 3
            ]);
        	$fullpaper = EventFullPaper::create(array(
        		"author_id"			=> Auth::user()->user_id,
        		"event_id"			=> $event->event_id,
        		"abstract_id"		        => $id,
        		"title"				=> $data['paper_title'],
        		"file"				=> $fileName,
                        "blind_file"			=> $blindfileName,
        		"code"				=> $code,
                        "paper_kind"	                => $data['paper_kind']
        	));
            $fid = $fullpaper->id;

            $mail = curl_init(url('mail_send?event='.$data['event_id'].'&abstract='.$id.'&paper'.$fid.'=&template=13'.'&user_id='.Auth::user()->user_id));
            curl_exec($mail);
            $users = Users::where('user_type_id','>=', 2)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == Auth::user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = Auth::user()->first_name;
                }
                $notification = Notifications::create(array(
                    'title' => 'New Paper Submitted By '.$createdBy,
                    'description' => 'Conference '.$event->title_en.' has new paper submitted by '.$createdBy,
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'blue',
                    'type' => 'paper-submitted',
                    'icon' => 'file',
                    'timeout' => 5000,
                    'url' => '/admin/events/conference/paper/'.$id,
                    'status' => 'info'
                ));
            }
        	return $id;
        }
    }

    public function comment(Request $request, $id)
    {
    	$data = $request->all();
         $user_type = 0;
        if(isset($data['user_type']))
        {
            $user_type = $data['user_type'];
        }
    	$file = $data['attachmentfilename'];
    	if ($request->hasFile('attachment')  &&  $request->file('attachment')->isValid()) {
            $comment = $request->file('attachment');
            $destinationPath = 'uploads/fullpapers/'.$data['event_id'].'/'.'comments/'; // upload path
            $extension = $comment->getClientOriginalExtension(); // getting image extension
            $fileName = $file;//$extension; // renameing image
            //$paper->move($destinationPath, $fileName); // uploading file to given path
            Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('attachment')->getRealPath()));
          // sending back with message
        }else{
        	$fileName = '';
        }
    	$comment = PaperComments::create(array(
    		"user_id"			=> Auth::user()->user_id,
    		"paper_id"			=> $id,
    		"message"			=> $data['message'],
    		"user_type" 		=> $user_type,
    		"filename"			=> $data['attachmentfilename'],
    		"file"				=> $data['attachmentname']
    	));
    	return $id;
    }

    public function status($id)
    {
    	$topics = array();
    	$paper = EventFullPaper::where('abstract_id', $id)->first();
    	if($paper){
            $admins = Users::where('user_type_id','>=',2)->get();
            $include = [];
            foreach ($admins as $admin) {
                array_push($include, $admin['user_id']);
            }
            array_push($include, Auth::user()->user_id);
            $comments = PaperComments::whereIn('user_id',$include)->where('paper_id', $paper->paper_id)->get();
    		$abstract = EventAbstract::where('abstract_id', $id)->first();
    		$event = Events::where('event_id', $paper->event_id)->first();
		    $topic = EventTopic::where('topic_id', $paper->topic_id)->first();
            $coauthors = Coauthors::where('paper_id', $paper->paper_id)->where('deleted',0)->get();
	    	return view('abstract.index')->with(array(
	    		"event" 		=> $event,
	    		"paper"			=> $paper,
	    		"abstract"		=> $abstract,
	    		"topics"		=> $topics,
	    		"topic"			=> $topic,
	    		"comments"		=> $comments,
                "coauthors"     => $coauthors

	    	));
		}else{
			return view('errors.404');
		}
    }

    public function ufp($id)
    {
    	$abstract = EventAbstract::where('abstract_id', $id)->update(array('status' => 3));
    	return redirect('/abstract/status/'.$id);
    }

    public function add_coauthor(Request $request)
    {
        $user = Users::where('email',$request['co_email'])->first();
        $err = '';
        if($user){
            $user_id = $user['user_id'];
        }else{
            if (!filter_var($request['co_email'], FILTER_VALIDATE_EMAIL) === false) {
                $new_user = Users::create([
                    'first_name' => $request['co_name'],
                    'email'      => $request['co_email']
                ]);
                $user_id = $new_user->id;
            } else {
                $err = '<br>'.'Email is not valied';
            }
        }
        $already = Coauthors::where('paper_id',$request['paper_id'])->where('user_id',$user_id)->where('deleted',0)->get();
        if($already->count() > 0){
            $err = '<br>'.$request['co_name'].' is Already a Co-Author on this paper';
        }
        $isAuthor = EventAttendance::where('event_id',$request['event_id'])->where('user_id',$user_id)->first();
        if($isAuthor){
            if($isAuthor['event_attendance_type_id'] == 3){

            }else{
                $updateEATI = EventAttendance::where('event_id',$request['event_id'])->where('user_id',$user_id)->update([  
                    'event_attendance_type_id' => 2
                ]);
            }
            $found = 1;
        }else{
            $found = 0;
        }
        if($user_id == Auth::user()->user_id){
            $err = '<br>'.'You are already the author of this page';
        }
        if($err == ''){
            if($found == 0){
                $register = EventAttendance::create(
                    [
                    'event_id' => $request['event_id'],
                    'user_id' => $user_id,
                    'event_attendance_type_id' => 2
                    ]
                );
            }
            $co = Coauthors::create([
                'paper_id' => $request['paper_id'],
                'event_id' => $request['event_id'],
                'user_id' => $user_id,
                'name' => $request['co_name'],
                'email' => $request['co_email']
            ]);
            return Response($co->user_id, 202);
        }else{
            return Response($err, 400);
        }
    }

    function remove_coauthor($id){
        $remove =  Coauthors::where('user_id',$id)->update([
            'deleted' =>  1
        ]);
        
        if($remove){
            $ca = Coauthors::where('user_id',$id)->first();
        
        $uAttType = EventAttendance::where('user_id',$ca['user_id'])->first();
        if($uAttType['event_attendance_type_id'] != 3){
            $upType = EventAttendance::where('event_attendance_id',$uAttType['event_attendance_id'])->update(
                [
                'event_attendance_type_id' => 1
                ]
                );
        }
                return Response("success", 200);

        }else{
            return Response("error", 200);
        }
        
    }

}
