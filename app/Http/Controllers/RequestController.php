<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;



use App\Http\Controllers\Controller;

use App\Models\EventMediaCoverages;
use App\Models\Events;


use App\Models\EventSpeakers;
use App\Models\EventSponsors;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\MailTemplates;

use Storage;
use Validator;
use Response;

class RequestController extends Controller
{
    //
    public function show_speaker($event_id)
    {

        $for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $speakers = EventSpeakers::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        $slug = $event['slug'];
        return view('requests.speaker')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'event_id' => $event_id,
            'speakers' => $speakers,
            'event' => $eventTitle,
            'slug' => $slug
            ));



    }

    public function show_sponsor($event_id)
    {

		$for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $sponsors = EventSponsors::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        $slug = $event['slug'];
        return view('requests.sponsor')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'event_id' => $event_id,
            'sponsors' => $sponsors,
            'event' => $eventTitle,
            'slug' => $slug
            ));



    }

    public function show_media_coverage($event_id)
    {

		$event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        $slug = $event['slug'];
        return view('requests.media_coverage')->with(
            array(
            'event_id' => $event_id,
            'event' => $eventTitle,
            'slug' => $slug

            ));


    }
    
    public function store_media_coverage(Request $request, $event_id)
    {

    	$data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'media_coverage_title' => 'required|max:255',
            //'media_coverage_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'media_coverage_description' => 'required|max:400'
          'organization' => 'required',
            'email' => 'required|email'
             
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
                
                 $to      = 'info@ierek-scholar.org';
               $subject = 'media request';
               $message = 'the following message request from '.$data['organization']. ' to be media in conference';
               $headers = 'From:'.$data['email'] . "\r\n" .
   
                          'X-Mailer: PHP/' . phpversion();

               mail($to, $subject, $message, $headers);

                return Response::json($id);
            }
        }
    }
    public function store_speaker(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email',
            'cv' => 'required|max:1000000',
            'img' => 'required|mimes:jpeg,jpg,png|max:1000000',
            'brief_description' => 'required|max:400'
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
            $imageName = 'speaker_'.substr(md5(microtime()),0,4);
            $cvName = 'speaker_'.substr(md5(microtime()),0,4);
            
            if ($request->hasFile('img')  &&  $request->file('img')->isValid()) 
                {
                    $img = $request->file('img');
                    $destinationPath = Events::conf_folder. "/". $event_id . "/" . Events::speakers_image_folder . "/"; // upload path
                    $extension = $img->getClientOriginalExtension(); // getting image extension
                    $imageName = $imageName . ".". $extension;//$extension; // renameing image
                    Storage::disk('secured')->put($destinationPath.$imageName ,file_get_contents($request->file('img')->getRealPath()));
                  // sending back with message
                }

                if ($request->hasFile('cv')  &&  $request->file('cv')->isValid()) 
                {
                    $cv = $request->file('cv');
                    $destinationPath =  Events::conf_folder. "/". $event_id . "/" . Events::speakers_cv_folder . "/"; // upload path
                    $extension = $cv->getClientOriginalExtension(); // getting image extension
                    $cvName = $cvName .".". $extension;//$extension; // renameing image
                    Storage::disk('secured')->put($destinationPath.$cvName ,file_get_contents($request->file('cv')->getRealPath()));
                  // sending back with message
                }
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
               $to      = 'info@ierek-scholar.org';
               $subject = 'speaker request';
               $message = 'the following message request '.$data['full_name']. 'to be speaker in conference';
               $headers = 'From:'.$data['email'] . "\r\n" .
   
                          'X-Mailer: PHP/' . phpversion();

               mail($to, $subject, $message, $headers);
               return Response::json($id);
            }
        }

    }
    public function store_sponsor(Request $request, $event_id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'sponsor_title' => 'required|max:255',
            //'sponsor_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'sponsor_description' => 'required|max:400'
            'company_name' => 'required',
            'brief_description' => 'required',
            'contact_person_name' => 'required',
            'email' => 'required|email',
            'proposal' => 'required'
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
            $imageName = 'sponsor_'.substr(md5(microtime()),0,4);
            
            if ($request->hasFile('img')  &&  $request->file('img')->isValid()) 
                {
                    $img = $request->file('img');
                    $destinationPath = Events::conf_folder. "/". $event_id . "/" . Events::sponsors_folder . "/"; // upload path
                    $extension = $img->getClientOriginalExtension(); // getting image extension
                    $imageName = $imageName . "." .$extension;//$extension; // renameing image
                    Storage::disk('secured')->put($destinationPath.$imageName ,file_get_contents($request->file('img')->getRealPath()));
                  // sending back with message
                }
            
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
                 $to      = 'info@ierek-scholar.org';
               $subject = 'sponsor request';
               $message = 'the following message request '.$data['contact_person_name']. ' to be sponsor to conference';
               $headers = 'From:'.$data['email'] . "\r\n" .
   
                          'X-Mailer: PHP/' . phpversion();

               mail($to, $subject, $message, $headers);
                return Response::json($id);
            }
        }

    }
}
