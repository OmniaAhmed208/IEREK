<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use Storage;
use Validator;
use Response;

class StudyabroadCategoriesController extends Controller
{
    //
    public function show()
    {
    	$categories = SubCategory::where('category_id', 3)->where('deleted','=', 0)->get();

        return view('admin.events.studyabroad.categories.show')->with(
            array(
            'categories' => $categories
            ));

    }

    public function filter($deleted)
    {
        switch($deleted)
        {
            case "create";
                return $this->create();
            break;
            case "active-only";
                $categories = SubCategory::where('category_id', 3)->where('deleted', '=', 0)->get();
                return View('admin.events.studyabroad.categories.show')->with(array('categories' => $categories) )->with('select','active-only');
            break;
            case "inactive-only";
                $categories = SubCategory::where('category_id', 3)->where('deleted', '=', 1)->get();
                return View('admin.events.studyabroad.categories.show')->with(array('categories' => $categories) )->with('select','inactive-only');
            break;
            case "all";
                $categories = SubCategory::where('category_id', 3)->get();
                return View('admin.events.studyabroad.categories.show')->with(array('categories' => $categories) )->with('select','all');
            break;
        }
    }

    public function create()
    {
        return view('admin.events.studyabroad.categories.create')->with(['category_id' => 3]);
    }

    public function edit($id)
    {
        
        $category = SubCategory::where('sub_category_id', $id)->firstOrFail();        

        return view('admin.events.studyabroad.categories.edit')->with(
            array(
                'category' => $category
                ));
    }
    
    


    public function store(Request $request)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            //'category_title' => 'required|max:255',
            //'category_img' => 'mimes:jpeg,jpg,png|max:1000000',
            //'category_description' => 'required|max:400'
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
            //new Studyabroad Categories
            // Store the new studyabroad categories data...
            $data['category_id'] = 3;
            $id = SubCategory::create($data);

            return Response::json($id);
        }

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }

            //'category_title' => 'required|max:255',
            //'category_description' => 'required|max:500'
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
            //Update Studyabroad Categories
            // Update the studyabroad categories data...
            unset($data['_token']);
            unset($data['_method']);
            $idu = SubCategory::where('sub_category_id', $id)->update($data);
  

                
            return Response::json($idu);
            
        }
    }

    public function destroy($id)
    {
        $delete = SubCategory::where('sub_category_id', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = SubCategory::where('sub_category_id', $id)->update(array(
                'deleted' => 0,
                ));
    }
}
