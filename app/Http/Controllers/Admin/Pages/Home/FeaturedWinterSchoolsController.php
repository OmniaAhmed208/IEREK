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

class FeaturedWinterSchoolsController extends Controller
{
    //
    public function index()
    {
      
        $featured_winter_schools = FeaturedEvents::where('deleted','=', 0)->where('category_id','=', 4)->get();
        
        return view('admin.pages.home.featured_winter_schools.show')->with(
            array(
            'featured_winter_schools' => $featured_winter_schools
            ))->with('select','active-only');
            
    }
    
    
    public function create()
    {
        $winterSchools = Events::where('sub_category_id', 19)->where('deleted','=', 0)->get();
         
        return view('admin.pages.home.featured_winter_schools.create')->with(
            array('winterSchools' => $winterSchools
            
            ));
    }
    
    public function store(Request $request)
    {
          $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
           
            'event_id' => 'required',
            'position' => 'required'
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
                'category_id' => 4,
           
            ));

            if($id)
            {
                
                return Response::json($id);
                
            }
        }
    }
    
    public function edit($id)
    {
         $featuredWinterSchool = FeaturedEvents::where('featured_event_sid', $id)->firstOrFail();
        $winterSchools = Events::where('sub_category_id', 19)->where('deleted','=', 0)->get();
        
        return view('admin.pages.home.featured_winter_schools.edit')->with(
            array(
                
                'featuredWinterSchool' => $featuredWinterSchool,
                'winterSchools' => $winterSchools
                
                ));
    }
    
        public function update(Request $request, $id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
           'event_id' => 'required',
            'position' => 'required'
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
    
       public function filter($deleted)
    {
        switch($deleted)
        {
            case "active-only";
                $featured_winter_schools = FeaturedEvents::where('deleted', '=', 0)->where('category_id','=', 4)->get();
                return View('admin.pages.home.featured_winter_schools.show')->with(array('featured_winter_schools' => $featured_winter_schools))->with('select','active-only');
            break;
            case "inactive-only";
               $featured_winter_schools = FeaturedEvents::where('deleted', '=', 1)->where('category_id','=', 4)->get();
                return View('admin.pages.home.featured_winter_schools.show')->with(array('featured_winter_schools' => $featured_winter_schools))->with('select','inactive-only');
            break;
            case "all";
                $featured_winter_schools = FeaturedEvents::where('category_id','=', 4)->get();
                return View('admin.pages.home.featured_winter_schools.show')->with(array('featured_winter_schools' => $featured_winter_schools))->with('select','all');
            break;
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
