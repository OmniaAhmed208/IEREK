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

class FeaturedSummerSchoolsController extends Controller
{
    //
    public function index()
    {
      
        $featured_summer_schools = FeaturedEvents::where('deleted','=', 0)->where('category_id','=', 3)->get();
        
        return view('admin.pages.home.featured_summer_schools.show')->with(
            array(
            'featured_summer_schools' => $featured_summer_schools
            ))->with('select','active-only');
            

    }

    public function filter($deleted)
    {
        switch($deleted)
        {
            case "active-only";
                $featured_summer_schools = FeaturedEvents::where('deleted', '=', 0)->where('category_id','=', 3)->get();
                return View('admin.pages.home.featured_summer_schools.show')->with(array('featured_summer_schools' => $featured_summer_schools))->with('select','active-only');
            break;
            case "inactive-only";
               $featured_summer_schools = FeaturedEvents::where('deleted', '=', 1)->where('category_id','=', 3)->get();
                return View('admin.pages.home.featured_summer_schools.show')->with(array('featured_summer_schools' => $featured_summer_schools))->with('select','inactive-only');
            break;
            case "all";
                $featured_summer_schools = FeaturedEvents::where('category_id','=', 3)->get();
                return View('admin.pages.home.featured_summer_schools.show')->with(array('featured_summer_schools' => $featured_summer_schools))->with('select','all');
            break;
        }
    }

    public function create()
    {
    	
        $summerSchools = Events::where('sub_category_id', 18)->where('deleted','=', 0)->get();
         
        return view('admin.pages.home.featured_summer_schools.create')->with(
            array('summerSchools' => $summerSchools
            
            ));


    }

    public function edit($id)
    {
        
        $featuredSummerSchool = FeaturedEvents::where('featured_event_sid', $id)->firstOrFail();
        $summerSchools = Events::where('sub_category_id', 18)->where('deleted','=', 0)->get();
        
        return view('admin.pages.home.featured_summer_schools.edit')->with(
            array(
                
                'featuredSummerSchool' => $featuredSummerSchool,
                'summerSchools' => $summerSchools
                
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
            //new Workshop Widgets
            // Store the new workshop widgets data...
           
            $id = FeaturedEvents::create(array(
                'event_id' => $data['event_id'],
                'position' => $data['position'],
                'category_id' => 3,
           
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
            //Update Workshop Widgets
            // Update the workshop widgets data...
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
