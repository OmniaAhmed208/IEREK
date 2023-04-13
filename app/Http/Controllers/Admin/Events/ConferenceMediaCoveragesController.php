<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventMediaCoverages;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use Storage;
use Validator;
use Response;

class ConferenceMediaCoveragesController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$media_coverages = EventMediaCoverages::where('event_id', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.conference.media_coverages.show')->with(
            array(
            'media_coverages' => $media_coverages, 
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
                        $media_coverages = EventMediaCoverages::where('deleted', '=', 0)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','active-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $media_coverages = EventMediaCoverages::where('deleted', '=', 0)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','active-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $media_coverages = EventMediaCoverages::where('deleted', '=', 0)->get();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','active-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "inactive-only";
                switch($accepted)   
                {
                    case "accepted";
                        $media_coverages = EventMediaCoverages::where('deleted', '=', 1)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','inactive-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $media_coverages = EventMediaCoverages::where('deleted', '=', 1)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','inactive-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $media_coverages = EventMediaCoverages::where('deleted', '=', 1)->get();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','inactive-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "all";
                switch($accepted)   
                {
                    case "accepted";
                        $media_coverages = EventMediaCoverages::where('accepted', '=', 1)->get();
                        return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','all')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $media_coverages = EventMediaCoverages::where('accepted', '=', 2)->get();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','all')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $media_coverages = EventMediaCoverages::all();
                         return View('admin.events.conference.media_coverages.show')->with(array('media_coverages' => $media_coverages) )->with('select','all')->with('accept', 'all')->with('event_id', $event_id)->with(array(
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
        $media_coverages = EventMediaCoverages::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.conference.media_coverages.create')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'event_id' => $event_id,
            'media_coverages' => $media_coverages,
            'event' => $eventTitle
            ));
    }

    public function edit($id)
    {
        
        $eventMediaCoverage = EventMediaCoverages::where('event_media_coverage_sid', $id)->firstOrFail();
        $event_id = $eventMediaCoverage['event_id'];
        
        $event = Events::where('event_id', $event_id)->where('deleted', 0)->first();

        $eventMediaCoverages = EventMediaCoverages::where('event_id', $event_id)->where('deleted', 0)->get()->first();

        
        $url1 = Storage::disk('public')->url('uploads/conferences/'.$event_id.'/'.'media_coverages/'.$eventMediaCoverage->img);
        
        $url = array(
            'img'     => $url1
        
            );

        return view('admin.events.conference.media_coverages.view')->with(
            array(
                'event_id' => $event_id,
                'event' => $event,
                'eventMediaCoverage' => $eventMediaCoverage,
                'eventMediaCoverages' => $eventMediaCoverages,
                'url' => $url
                
                ));
    }
    
    


    public function store(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'media_coverage_title' => 'required|max:255',
            //'media_coverage_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'media_coverage_description' => 'required|max:400'
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
            //new Conference MediaCoverages
            // Store the new conference media_coverages data...
            $imageName = 'media_coverage_'.substr(md5(microtime()),0,4).'.jpg';
            
            $id = EventMediaCoverages::create(array(
                'organization' => $data['organization'],
                'email' => $data['email'],
                'img' => $imageName,
                'brief_description' => $data['brief_description'],
                'media_type' => $data['media_type'],
                'event_id' => $event_id
            ));

            if($id)
            {
                
                // checking file is valid.
                if ($request->hasFile('img')  &&  $request->file('img')->isValid()) 
                {
                    $img = $request->file('img');
                    $destinationPath = 'uploads/conferences/'.$event_id.'/'.'media_coverages/'; // upload path
                    $extension = $img->getClientOriginalExtension(); // getting image extension
                    $fileName = $imageName;//$extension; // renameing image
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('img')->getRealPath()));
                  // sending back with message
                }

                return Response::json($id);
            }
        }

    }

    public function update(Request $request, $id)
    {
    
        $data = $request->all();
        $idu = EventMediaCoverages::where('event_media_coverage_sid', $id)->update(array(
                'accepted' => $data['media_coverage_status']
                ));
        
        return Response::json($idu);

    }
    public function accept($id)
    {
        $accept = EventMediaCoverages::where('event_media_coverage_sid', $id)->update(array(
                'accepted' => 1,
                ));
    }

    public function reject($id)
    {
        $accept = EventMediaCoverages::where('event_media_coverage_sid', $id)->update(array(
                'accepted' => 2,
                ));
    }

    public function destroy($id)
    {
        $delete = EventMediaCoverages::where('event_media_coverage_sid', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = EventMediaCoverages::where('event_media_coverage_sid', $id)->update(array(
                'deleted' => 0,
                ));
    }
   
}
