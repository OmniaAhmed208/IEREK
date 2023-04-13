<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventSpeakers;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use Storage;
use Validator;
use Response;



class ConferenceSpeakersController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$speakers = EventSpeakers::where('event_id', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.conference.speakers.show')->with(
            array(
            'speakers' => $speakers, 
            'event_id' => $event_id,
            'event' => $eventTitle
            ));

    }

    public function filter($event_id, $deleted, $accepted)
    {

        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
       
        switch($deleted)
        {
            case "active-only";
                switch($accepted)   
                {
                    case "accepted";
                        $speakers = EventSpeakers::where('deleted', '=', 0)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','active-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $speakers = EventSpeakers::where('deleted', '=', 0)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','active-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $speakers = EventSpeakers::where('deleted', '=', 0)->get();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','active-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "inactive-only";
                switch($accepted)   
                {
                    case "accepted";
                        $speakers = EventSpeakers::where('deleted', '=', 1)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','inactive-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $speakers = EventSpeakers::where('deleted', '=', 1)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','inactive-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $speakers = EventSpeakers::where('deleted', '=', 1)->get();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','inactive-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "all";
                switch($accepted)   
                {
                    case "accepted";
                        $speakers = EventSpeakers::where('accepted', '=', 1)->get();
                        return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','all')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $speakers = EventSpeakers::where('accepted', '=', 2)->get();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','all')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $speakers = EventSpeakers::all();
                         return View('admin.events.conference.speakers.show')->with(array('speakers' => $speakers) )->with('select','all')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
        }

    }

    public function create($event_id)
    {
    	$for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $speakers = EventSpeakers::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.conference.speakers.create')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'event_id' => $event_id,
            'speakers' => $speakers,
            'event' => $eventTitle
            ));
    }

    public function edit($id)
    {
        
        $eventSpeaker = EventSpeakers::where('event_speaker_sid', $id)->firstOrFail();
        $event_id = $eventSpeaker['event_id'];
        
        $event = Events::where('event_id', $event_id)->where('deleted', 0)->first();

        $eventSpeakers = EventSpeakers::where('event_id', $event_id)->where('deleted', 0)->get()->first();

        
        return view('admin.events.conference.speakers.view')->with(
            array(
                'event_id' => $event_id,
                'event' => $event,
                'eventSpeaker' => $eventSpeaker,
                'eventSpeakers' => $eventSpeakers,               
                ));
    }
    
    


    public function store(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'speaker_title' => 'required|max:255',
            //'speaker_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'speaker_description' => 'required|max:400'
        ]);

        // return validation errors if exist
        if ($validator->fails())
        {
            $dd = array(
                'success' => false,
                'errs' => $validator->getMessageBag()->toArray()
            );

            echo json_encode($dd);
        }
        else
        {
            //new Conference Speakers
            // Store the new conference speakers data...
            $imageName = 'speaker_'.substr(md5(microtime()),0,4).'.jpg';
            $cvName = 'speaker_'.substr(md5(microtime()),0,4).'.jpg';
            $id = EventSpeakers::create(array(
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'img' => $imageName,
                'cv' => $cvName,
                'brief_description' => $data['brief_description'],
                'university' => $data['university'],
                'linkedin' => $data['linkedin'],
                'twitter' => $data['twitter'],
                'facebook' => $data['facebook'],
                'event_id' => $event_id
            ));

            if($id)
            {
                
                // checking file is valid.
                if ($request->hasFile('img')  &&  $request->file('img')->isValid()) 
                {
                    $img = $request->file('img');
                    $destinationPath = 'uploads/conferences/'.$event_id.'/'.'speakers/'.'images/'; // upload path
                    $extension = $img->getClientOriginalExtension(); // getting image extension
                    $fileName = $imageName;//$extension; // renameing image
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('img')->getRealPath()));
                  // sending back with message
                }

                if ($request->hasFile('cv')  &&  $request->file('cv')->isValid()) 
                {
                    $cv = $request->file('cv');
                    $destinationPath = 'uploads/conferences/'.$event_id.'/'.'speakers/'.'cvs/'; // upload path
                    $extension = $cv->getClientOriginalExtension(); // getting image extension
                    $fileName = $cvName;//$extension; // renameing image
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('cv')->getRealPath()));
                  // sending back with message
                }


                return Response::json($id);
            }
        }

    }

    public function update(Request $request, $id)
    {

        $data = $request->all();

        $idu = EventSpeakers::where('event_speaker_sid', $id)->update(array(
                'accepted' => $data['speaker_status']
                ));

        return Response::json($idu);    
    }

    public function accept($id)
    {
        $accept = EventSpeakers::where('event_speaker_sid', $id)->update(array(
                'accepted' => 1,
                ));
    }

    public function reject($id)
    {
        $accept = EventSpeakers::where('event_speaker_sid', $id)->update(array(
                'accepted' => 2,
                ));
    }

    public function destroy($id)
    {
        $delete = EventSpeakers::where('event_speaker_sid', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = EventSpeakers::where('event_speaker_sid', $id)->update(array(
                'deleted' => 0,
                ));
    }
   
}
