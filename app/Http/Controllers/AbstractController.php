<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Events;
use App\Models\Users;
use App\Models\EventAttendance;
use App\Models\EventTopic;
use App\Models\EventAbstract;
use App\Models\EventAdmins;
use App\Models\Notifications;
use Response;
use Auth;
use Storage;
use Session;
//use \App\Models\conference_link_out;


class AbstractController extends Controller
{
    //
	public function myabstracts()
	{
		$abstract_events = EventAbstract::distinct()
                        ->select('event_id')
                        ->where('author_id', Auth::user()->user_id)
                        ->groupBy('event_id')
                        ->get();
		$abstractall = array();
		foreach($abstract_events as $abstract_event)
		{
			$eventabstracts = array();
			$event = Events::where('event_id', $abstract_event->event_id)->first();
			$abstracts = EventAbstract::where('event_id', $event->event_id)->where('author_id', Auth::user()->user_id)->get();
			$eventabstracts['title'] = $event->title_en;
			$eventabstracts['slug'] = $event->slug;

			foreach($abstracts as $abstract)
			{
				$abstractsevent = array();
				$abstractsevent['title'] = $abstract->title;
				$abstractsevent['id'] = $abstract->abstract_id;
				$abstractsevent['created_at'] = $abstract->created_at;
				$abstractsevent['status'] = $abstract->status;
				array_push($eventabstracts, $abstractsevent);
			}
			array_push($abstractall, $eventabstracts);
		}
		return view('myabstracts')->with(array('abstracts' => $abstractall));
	}

	public function myevents()
	{
		$EventAttendance = EventAttendance::where('user_id', Auth::user()->user_id)->where('unregistered', 0)->get();
		return view('myevents')->with(array('events' => $EventAttendance));
	}

    public function index($slug){
        
  // $event_link_out  =  Events::with('get_conference_link_out')->get();
  // dd($event_link_out->first()->get_conference_link_out());
	    $event = Events::where('slug', $slug)->first();
	    $event_id = $event['event_id'];
    	if(Auth::check()){
    		$isRegistered = EventAttendance::where('event_id', $event_id)->where('user_id', Auth::user()->user_id)->first();
	    	if($isRegistered){
	    		$user = Users::where('user_id', Auth::user()->user_id)->first();
		    	$topics = EventTopic::where('event_id', $event_id)->orderBy('position')->get();
		    	return view('abstract.index')->with(array(
		    		"event" 		=> $event,
		    		"user"			=> $user,
		    		"topics"		=> $topics
		    	));
    	}else{
    		return redirect('/events/'.$event['slug']);
    	}
    	}else{
    		return redirect('/events/'.$event['slug']);
    }
    }

    public function submit(Request $request)
    {
    	$data = $request->all();
    	$event = Events::where('event_id', $data['event_id'])->first();
    	$code = strtoupper(substr($event->title_en, 0,3)).'-'.strtoupper(substr(md5(microtime()),0,4)).'-A';
    	if ($request->hasFile('abstractfile')  &&  $request->file('abstractfile')->isValid()) {
            $abstract = $request->file('abstractfile');
            $destinationPath = EventAbstract::abstract_folder. "/". $data['event_id'] . "/"; // upload path
            $extension = $abstract->getClientOriginalExtension(); // getting image extension
            $fileName = $code.'.'.$extension;//$extension; // renameing image
            //$abstract->move($destinationPath, $fileName); // uploading file to given path
            Storage::disk('secured')->put($destinationPath.$fileName ,file_get_contents($request->file('abstractfile')->getRealPath()));
          // sending back with message
        }else{
        	$fileName = 'No File';
        }
    	$abstract = EventAbstract::create(array(
    		"author_id"			=> Auth::user()->user_id,
    		"event_id"			=> $event->event_id,
    		"topic_id"			=> $data['topic_id'],
    		"title"				=> $data['abstract_title'],
    		"abstract"			=> $data['abstract_content'],
    		"file"				=> $fileName,
    		"code"				=> $code
    	));
    	$id = $abstract->id;
        $mail = curl_init(url('mail_send?event='.$data['event_id'].'&abstract='.$id.'&paper=&template=12'.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);
        
    	$addcontent = EventAbstract::where('abstract_id',$id)->update(['abstract' => $data['abstract_content']]);
        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            $notification = Notifications::create(array(
                'title' => 'New Abstract Submitted By '.$createdBy,
                'description' => 'Conference '.$event->title_en.' has new abstract submitted by '.$createdBy,
                'user_id' => $users[$x]['user_id'],
                'color' => 'brown',
                'type' => 'abstract-submitted',
                'icon' => 'file',
                'timeout' => 5000,
                'url' => '/admin/events/conference/abstract/'.$id,
                'status' => 'info'
            ));
        }

    	return $id;
    }

    public function status($id)
    {
    	$topics = array();
    	$abstract = EventAbstract::where('abstract_id', $id)->first();
    	if($abstract){
    		$event = Events::where('event_id', $abstract->event_id)->first();
		    $topic = EventTopic::where('topic_id', $abstract->topic_id)->first();
	    	return view('abstract.index')->with(array(
	    		"event" 		=> $event,
	    		"abstract"		=> $abstract,
	    		"topics"		=> $topics,
	    		"topic"			=> $topic
	    	));
		}else{
			return view('errors.404');
		}
    }
}
