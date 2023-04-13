<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin\Pages\Home;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use App\Models\FeaturedEvents;

use Storage;
use Validator;
use Response;

class FeaturedConferencesController extends Controller
{
    //
    public function index()
    {
      
        $featured_conferences = FeaturedEvents::where('deleted','=', 0)->where('category_id','=', 1)->get();
        
        return view('admin.pages.home.featured_conferences.show')->with(
            array(
            'featured_conferences' => $featured_conferences
            ))->with('select','active-only');
            

    }

    public function filter($deleted)
    {
        switch($deleted)
        {
            case "active-only";
                $featured_conferences = FeaturedEvents::where('deleted', '=', 0)->where('category_id','=', 1)->get();
                return View('admin.pages.home.featured_conferences.show')->with(array('featured_conferences' => $featured_conferences))->with('select','active-only');
            break;
            case "inactive-only";
               $featured_conferences = FeaturedEvents::where('deleted', '=', 1)->where('category_id','=', 1)->get();
                return View('admin.pages.home.featured_conferences.show')->with(array('featured_conferences' => $featured_conferences))->with('select','inactive-only');
            break;
            case "all";
                $featured_conferences = FeaturedEvents::where('category_id','=', 1)->get();
                return View('admin.pages.home.featured_conferences.show')->with(array('featured_conferences' => $featured_conferences))->with('select','all');
            break;
        }
    }

    public function create()
    {
    	
        $conferences = Events::where('category_id', 1)->where('deleted','=', 0)->get();
         
        return view('admin.pages.home.featured_conferences.create')->with(
            array('conferences' => $conferences
            
            ));


    }

    public function edit($id)
    {
        
        $featuredConference = FeaturedEvents::where('featured_event_sid', $id)->firstOrFail();
        $conferences = Events::where('category_id', 1)->where('deleted','=', 0)->get();
        
        return view('admin.pages.home.featured_conferences.edit')->with(
            array(
                
                'featuredConference' => $featuredConference,
                'conferences' => $conferences
                
                ));
    }
    
    


    public function store(Request $request)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'widget_title' => 'required|max:255',
            //'widget_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'widget_description' => 'required|max:400'
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
            //new Conference Widgets
            // Store the new conference widgets data...
           
            $id = FeaturedEvents::create(array(
                'event_id' => $data['event_id'],
                'position' => $data['position'],
                'category_id' => 1
           
            ));

            if($id)
            {
                
                return Response::json($id);
                
            }
        }

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }

            //'widget_title' => 'required|max:255',
            //'widget_description' => 'required|max:500'
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
            //Update Conference Widgets
            // Update the conference widgets data...
            $idu = FeaturedEvents::where('featured_event_sid', $id)->update(array(
                
                'position' => $data['position'],
                'event_id' => $data['event_id']
                
            ));
            if($idu)
            {
                 
                 return Response::json($idu);
            }
        }
    }

    public function destroy($id)
    {
        $delete = FeaturedEvents::where('featured_event_sid', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = FeaturedEvents::where('featured_event_sid', $id)->update(array(
                'deleted' => 0,
                ));
    }
}
