<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\EventAttendance;
use App\Models\EventTopic;
use App\Models\EventAbstract;
use App\Models\Notifications;
use App\Models\Users;
use App\Models\EventFullPaper;
use Validator;
use Storage;
use Session;

class MigrationController extends Controller
{
    //

	private function vurl($url,$with){
		return view('admin.events.conference.migration.'.$url)->with($with);
	}

    public function index($event_id){

    	$event = Events::where('event_id',$event_id)->first();
    	$topics = EventTopic::where('event_id',$event_id)->get();
        $abstracts = EventAbstract::where('event_id', $event_id)->orderBy('created_at','EASC')->get();
    	return $this->vurl('index',[
    		'event' => $event,
    		'topics' => $topics,
            'abstracts' => $abstracts
    	]);
    }

    public function _abstract(Request $request)
    {
        $data = $request->all();
        $tuser = Users::where('email',$data['user_email'])->first();
        if($tuser != null){
            $event = Events::where('event_id', $data['event_id'])->first();
            $code = strtoupper(substr($event->title_en, 0,3)).'-'.strtoupper(substr(md5(microtime()),0,4)).'-A';
            if ($request->hasFile('abstractfile')  &&  $request->file('abstractfile')->isValid()) {
                $abstract = $request->file('abstractfile');
                $destinationPath = 'uploads/abstracts/'.$data['event_id'].'/'; // upload path
                $extension = $abstract->getClientOriginalExtension(); // getting image extension
                $fileName = $code.'.'.$extension;//$extension; // renameing image
                //$abstract->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('abstractfile')->getRealPath()));
              // sending back with message
            }else{
                $fileName = 'No File';
            }
            $abstract = EventAbstract::create(array(
                "author_id"         => $tuser->user_id,
                "event_id"          => $event->event_id,
                "topic_id"          => $data['topic_id'],
                "title"             => $data['abstract_title'],
                "abstract"          => $data['abstract_content'],
                "file"              => $fileName,
                "code"              => $code
            ));
            $id = $abstract->id;
            // $mail = curl_init(url('mail_send?event='.$data['event_id'].'&abstract='.$id.'&paper=&template=12'.'&user_id='.Auth::user()->user_id));
            // curl_exec($mail);
            
            $addcontent = EventAbstract::where('abstract_id',$id)->update(['abstract' => $data['abstract_content']]);
            $users = Users::where('user_type_id','>=', 2)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == auth()->user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = $tuser->first_name;
                }
                $notification = Notifications::create(array(
                    'title' => 'New Abstract Migrated By '.$createdBy,
                    'description' => 'Conference '.$event->title_en.' has new abstract migration by '.$createdBy,
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'brown',
                    'type' => 'abstract-submitted',
                    'icon' => 'file',
                    'timeout' => 5000,
                    'url' => '/admin/events/conference/abstract/'.$id,
                    'status' => 'info'
                ));
            }
            Session::flash('success', 'Abstract migrated successfully');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);
        }else{
            Session::flash('danger', 'Email entered is not a registerd user');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);    
        }
    }

    public function register(Request $request){
        $data = $request->all();
        $tuser = Users::where('email',$data['user_email'])->first();
        if($tuser != null){
            $check = EventAttendance::where("event_id", $data['event_id'])->where("user_id", $tuser['user_id'])->first();
            $event = Events::where('event_id', $data['event_id'])->first();
            if(count($check) > 0){
               $register = EventAttendance::where('event_attendance_id', $check->event_attendance_id)->update(array('unregistered' => 0));
            }else{
                $register = EventAttendance::create(array(
                    "event_id"                  => $data['event_id'],
                    "user_id"                   => $tuser['user_id'],
                    "event_attendance_type_id"  => 1
                ));
            }

            Session::flash('success', 'User registered by migration successfully');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);
        }else{
            Session::flash('danger', 'Email entered is not a registerd user');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);    
        }
    }

    public function paper(Request $request)
    {
        $data = $request->all();
        $abstractf = EventAbstract::where('abstract_id',$data['abstract_id'])->first();
        $tuser = Users::where('user_id',$abstractf['author_id'])->first();
        if($tuser != null){
            $event = Events::where('event_id', $data['event_id'])->first();
            $code = strtoupper(substr($event->title_en, 0,3)).'-'.strtoupper(substr(md5(microtime()),0,4)).'-P';
            $validator = Validator::make($request->all(), [
                'fullfile' => 'max:51200|min:0|mimes:doc,docx'
            ]);
            if ($validator->fails())
            {
                $dd = array(
                    'success' => false,
                    'errs' => $validator->getMessageBag()->toArray()
                );
                Session::flash('danger', 'Paper migration failed');
                return redirect('/admin/events/conference/migration/'.$data['event_id'])->with(['errors' => $dd]);
            }else{
                if ($request->hasFile('fullfile')  &&  $request->file('fullfile')->isValid()) {
                    $fullpaper = $request->file('fullfile');
                    $destinationPath = 'uploads/fullpapers/'.$data['event_id'].'/'; // upload path
                    $extension = $fullpaper->getClientOriginalExtension(); // getting image extension
                    $fileName = $code.'.'.$extension;//$extension; // renameing image
                    //$paper->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('fullfile')->getRealPath()));
                  // sending back with message
                }else{
                    $fileName = '';
                }
                $abstract = EventAbstract::where('abstract_id', $data['abstract_id'])->update(array('status' => 4));
                
                $toAuthor = EventAttendance::where('event_id',$event->event_id)->where('user_id', $abstractf['author_id'])->update([
                    'event_attendance_type_id' => 3
                ]);

                $fullpaper = EventFullPaper::create(array(
                    "author_id"         => $tuser->user_id,
                    "event_id"          => $event->event_id,
                    "abstract_id"       => $data['abstract_id'],
                    "title"             => $data['paper_title'],
                    "file"              => $fileName,
                    "code"              => $code
                ));
                $fid = $fullpaper->id;

                $users = Users::where('user_type_id','>=', 2)->get();
                $cusers = sizeof($users);
                for ($x = 0; $x < $cusers; $x++) {
                    if($users[$x]['user_id'] == auth()->user()->user_id){
                        $createdBy = 'You';
                    }else{
                        $createdBy = auth()->user()->first_name;
                    }
                    $notification = Notifications::create(array(
                        'title' => 'New Paper Migrated By '.$createdBy,
                        'description' => 'Conference '.$event->title_en.' has new paper migrated by '.$createdBy,
                        'user_id' => $users[$x]['user_id'],
                        'color' => 'blue',
                        'type' => 'paper-submitted',
                        'icon' => 'file',
                        'timeout' => 5000,
                        'url' => '/admin/events/conference/paper/'.$data['abstract_id'],
                        'status' => 'info'
                    ));
                }
            }
            Session::flash('success', 'Paper migrated successfully');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);
        }else{
            Session::flash('danger', 'Email entered is not a registerd user');
            return redirect('/admin/events/conference/migration/'.$data['event_id']);    
        }
    }

}
