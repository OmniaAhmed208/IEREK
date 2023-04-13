<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventSponsors;
use App\Models\SponsorShip;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use Storage;
use Validator;
use Response;

class ConferenceSponsorsController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$sponsors = SponsorShip::where('sponsor_event', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.conference.sponsors.show')->with(
            array(
            'sponsors' => $sponsors, 
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
                        $sponsors = SponsorShip::where('deleted', '=', 0)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','active-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $sponsors = SponsorShip::where('deleted', '=', 0)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','active-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $sponsors = SponsorShip::where('deleted', '=', 0)->get();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','active-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "inactive-only";
                switch($accepted)   
                {
                    case "accepted";
                        $sponsors = SponsorShip::where('deleted', '=', 1)->where('accepted', '=', 1)->get();
                        return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','inactive-only')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $sponsors = SponsorShip::where('deleted', '=', 1)->where('accepted', '=', 2)->get();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','inactive-only')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $sponsors = SponsorShip::where('deleted', '=', 1)->get();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','inactive-only')->with('accept', 'all')->with('event_id', $event_id)->with(array(
                         'event' => $eventTitle));
                    break;
                }
            break;
            case "all";
                switch($accepted)   
                {
                    case "accepted";
                        $sponsors = SponsorShip::where('accepted', '=', 1)->get();
                        return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','all')->with('accept', 'accepted')->with('event_id', $event_id)->with(array('event' => $eventTitle));
                    break;
                    case "rejected";
                        $sponsors = SponsorShip::where('accepted', '=', 2)->get();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','all')->with('accept', 'rejected')->with('event_id', $event_id)->with(array(
                               'event' => $eventTitle));
                    break;
                    case "all";
                         $sponsors = SponsorShip::all();
                         return View('admin.events.conference.sponsors.show')->with(array('sponsors' => $sponsors) )->with('select','all')->with('accept', 'all')->with('event_id', $event_id)->with(array(
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
        $sponsors = EventSponsors::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.conference.sponsors.create')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'event_id' => $event_id,
            'sponsors' => $sponsors,
            'event' => $eventTitle
            ));
    }

    public function edit($id)
    {
        
        $eventSponsor = EventSponsors::where('event_sponsor_sid', $id)->firstOrFail();
        $event_id = $eventSponsor['event_id'];
        
        $event = Events::where('event_id', $event_id)->where('deleted', 0)->first();

        $eventSponsors = EventSponsors::where('event_id', $event_id)->where('deleted', 0)->get()->first();
      

        return view('admin.events.conference.sponsors.view')->with(
            array(
                'event_id' => $event_id,
                'event' => $event,
                'eventSponsor' => $eventSponsor,
                'eventSponsors' => $eventSponsors,
               
                ));
    }
    
    


    public function store(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'sponsor_title' => 'required|max:255',
            //'sponsor_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'sponsor_description' => 'required|max:400'
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
            //new Conference Sponsors
            // Store the new conference sponsors data...
            $imageName = 'sponsor_'.substr(md5(microtime()),0,4).'.jpg';
            
            $id = EventSponsors::create(array(
                'company_name' => $data['company_name'],
                'brief_description' => $data['brief_description'],
                'img' => $imageName,
                'website' => $data['website'],
                'contact_person_name' => $data['contact_person_name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'proposal' => $data['proposal'],
                                
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
                    $destinationPath = 'uploads/conferences/'.$event_id.'/'.'sponsors/'; // upload path
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

        $idu = EventSponsors::where('event_sponsor_sid', $id)->update(array(
                'accepted' => $data['sponsor_status']
                ));

        return Response::json($idu);

    }
    public function accept($id)
    {
        $accept = SponsorShip::where('sponsor_id', $id)->update(array(
                'accepted' => 1,
                ));
    }

    public function reject($id)
    {
        $accept = SponsorShip::where('sponsor_id', $id)->update(array(
                'accepted' => 2,
                ));
    }

    public function destroy($id)
    {
        $delete = SponsorShip::where('sponsor_id', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = SponsorShip::where('sponsor_id', $id)->update(array(
                'deleted' => 0,
                ));
    }
   
    
    public function showSponsor($id)
    {
        
        $eventSponsor = SponsorShip::where('sponsor_id', $id)->first();
      
      
        return view('admin.events.conference.sponsors.show_sponsor')->with('eventSponsor', $eventSponsor);
    }
}
