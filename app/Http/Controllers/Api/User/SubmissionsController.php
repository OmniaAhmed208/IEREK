<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\EventAbstract;

class SubmissionsController extends Controller
{
    //
	public function index()
    {
    	$status = array(
			0 => 'Abstract Pending Approval',
			1 => 'Abstract Under Revision',
			2 => 'Abstract Accetped',
			3 => 'Upload Your Full Paper',
			4 => 'Full Paper Pending Approval',
			5 => 'Full Paper Approved',
			6 => 'Full Paper Awaiting Reviewers Decision',
			7 => 'Full Paper Accetped',
			8 => 'Full Paper Rejected',
			9 => 'Abstract Rejected'
		);
    	$id = auth()->user()->user_id;
    	$abstract_events = EventAbstract::distinct()->select('event_id')->where('author_id', $id)->groupBy('event_id')->get();
		$abstractall = array();
		foreach($abstract_events as $abstract_event)
		{
			$eventabstracts = array();
			$event = Events::where('event_id', $abstract_event->event_id)->first();
			$abstracts = EventAbstract::where('event_id', $event->event_id)->where('author_id', $id)->get();
			$eventabstracts['event'] = ['title' => $event->title_en, 'event_id' => $event->event_id];
			$eventabstracts['abstracts'] = [];

			foreach($abstracts as $abstract)
			{
				$abstractsevent = [];
				$abstractsevent['title'] = $abstract->title;
				$abstractsevent['abstract_id'] = $abstract->abstract_id;
				$abstractsevent['payment'] = $abstract->payment;
				$abstractsevent['status'] = $status[$abstract->status];
				$abstractsevent['created_at'] = date('Y-m-d H:m:i', strtotime($abstract->created_at));
				array_push($eventabstracts['abstracts'], $abstractsevent);
			}
			array_push($abstractall, $eventabstracts);
		}

    	return response()->json($abstractall, 200);
    }
}
