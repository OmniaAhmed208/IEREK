<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventAttendance;

class EventsController extends Controller
{
    //
    public function index()
    {
    	$id = auth()->user()->user_id;
    	$events = EventAttendance::distinct('event_id')->where('user_id', $id)->where('unregistered', 0)->with('events')->get(['event_id']);
    	$myEvents = [];
    	foreach($events as $e){
    		if(strtotime($e->events->start_date) >= strtotime('today')){
		        $event = EventAttendance::where('user_id', $id)->where('event_id', $e->event_id)->first(['event_id','payment','postpone','created_at','event_attendance_id']);
		        $event['title'] = $e->events->title_en;
		        $event['start_date'] = $e->events->start_date;
		        $event['category_id'] = $e->events->category_id;
		        array_push($myEvents, $event);
	    	}
    	}    
		usort($myEvents, 
			function($a, $b)
			{
			    $t1 = strtotime($a['start_date']);
			    $t2 = strtotime($b['start_date']);
			    return $t1 - $t2;
			}
		);

    	return response()->json($myEvents, 200);
    }

    public function unregister($event_attendance_id)
    {
    	$id = auth()->user()->user_id;
    	
    	$unregister = EventAttendance::where('event_attendance_id', $event_attendance_id)->where('user_id',$id)->update(['unregistered' => 1]);

    	return response()->json([
            "message"   => "Successfully unregistered from event!"
        ], 200);
    }
}