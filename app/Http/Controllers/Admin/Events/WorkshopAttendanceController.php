<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Events;
use App\Models\EventAttendance;

class WorkshopAttendanceController extends Controller
{
    //
	public function filter($event_id, $deleted)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        switch($deleted)
        {
            case "active-only";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('deleted', '=', 0)->where('unregistered',0)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'active-only'
            	));
            break;
            case "inactive-only";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('deleted', '=', 1)->where('unregistered',0)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'inactive-only'
            	));
            break;
            case "all";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('unregistered',0)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'all'
            	));
            break;
            case "paid";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('payment', '=', 1)->where('unregistered',0)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'paid'
            	));
            break;
            case "not-paid";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('payment', '=', 0)->where('unregistered',0)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'not-paid'
            	));
            break;
            case "unregistered";
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('unregistered',1)->where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.index')->with(array(
            		'event' => $eventTitle,
            		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event,
            		'event_id'	=> $event_id,
            		'select'	=> 'unregistered'
            	));
            break;
        }
    }

    public function index($event_id)
    {
    	$event = Events::where('event_id', $event_id)->firstOrFail();
    	$attendance = EventAttendance::where('event_id', $event_id)->get();
    	return view('admin.events.workshop.attendance.index')->with(array(
    		'event' => $event['title_en'],
    		'event_id' => $event['event_id'],
    		'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event
    	));
    }

    public function export(Request $request)
    {
        $filter = $request['users_filter'];
        $event_id = $request['event_id'];
        switch($filter)
        {
            case 'all':
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('event_id',$event_id)->get();
                return View('admin.events.workshop.attendance.export')->with(array(
                    'attendances' => $attendance,
                    'type' => 'All',
                    'event' => $event
                ));
            break;
            case 'audience':
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('event_id',$event_id)->where('event_attendance_type_id', 1)->where('deleted',0)->where('unregistered',0)->get();
                return View('admin.events.workshop.attendance.export')->with(array(
                    'attendances' => $attendance,
                    'type' => 'Audience',
                    'event' => $event
                ));
            break;
            case 'paid':
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('event_id',$event_id)->whereIn('event_attendance_type_id', array(1,2,3))->where('deleted',0)->where('unregistered',0)->where('payment',1)->get();
                return View('admin.events.workshop.attendance.export')->with(array(
                    'attendances' => $attendance,
                    'type' => 'Paid',
                    'event' => $event
                ));
            break;
            case 'not-paid':
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('event_id',$event_id)->whereIn('event_attendance_type_id', array(1,2,3))->where('deleted',0)->where('unregistered',0)->where('payment',0)->get();
                return View('admin.events.workshop.attendance.export')->with(array(
                    'attendances' => $attendance,
                    'type' => 'Not Paid',
                    'event' => $event
                ));
            break;
            case 'unregistered':
                $event = Events::where('event_id',$event_id)->first();
                $attendance = EventAttendance::where('event_id',$event_id)->whereIn('event_attendance_type_id', array(1,2,3))->where('deleted',0)->where('unregistered',0)->where('unregistered',1)->get();
                return View('admin.events.workshop.attendance.export')->with(array(
                    'attendances' => $attendance,
                    'type' => 'Unregistered',
                    'event' => $event
                ));
            break;
        }
    }
}
