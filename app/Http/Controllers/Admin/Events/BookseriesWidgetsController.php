<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\WidgetTypes;
use App\Models\EventWidgets;
use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use Storage;
use Validator;
use Response;

class BookseriesWidgetsController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$widgets = EventWidgets::where('event_id', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.bookseries.widgets.show')->with(
            array(
            'widgets' => $widgets, 
            'event_id' => $event_id,
            'event' => $eventTitle
            ));

    }

    public function filter($event_id, $deleted)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        switch($deleted)
        {
            case "active-only";
                $widgets = EventWidgets::where('event_id','=', $event_id)->where('deleted', '=', 0)->get();
                return View('admin.events.bookseries.widgets.show')->with(array('widgets' => $widgets) )->with('select','active-only')->with('event_id', $event_id)->with(array(
            'event' => $eventTitle));
            break;
            case "inactive-only";
                $widgets = EventWidgets::where('event_id','=', $event_id)->where('deleted', '=', 1)->get();
                return View('admin.events.bookseries.widgets.show')->with(array('widgets' => $widgets) )->with('select','inactive-only')->with('event_id', $event_id)->with(array(
            'event' => $eventTitle));
            break;
            case "all";
                $widgets = EventWidgets::where('event_id','=', $event_id)->get();
                return View('admin.events.bookseries.widgets.show')->with(array('widgets' => $widgets) )->with('select','all')->with('event_id', $event_id)->with(array(
            'event' => $eventTitle));
            break;
        }
    }

    public function create($event_id)
    {
    	$for = EventAttendanceType::all();
        $condition = EventDateType::whereBetween('event_date_type_id',array(5,7) )->get();
        $widgetTypes = WidgetTypes::all();
        $widgets = EventWidgets::where('event_id', $event_id)->where('deleted','=', 0)->get();
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
        return view('admin.events.bookseries.widgets.create')->with(
            array(
            'for' => $for, 
            'condition' => $condition, 
            'widgetTypes' => $widgetTypes, 
            'event_id' => $event_id,
            'widgets' => $widgets,
            'event' => $eventTitle
            ));
    }

    public function edit($id)
    {
        
        $eventWidget = EventWidgets::where('event_widget_sid', $id)->firstOrFail();
        $event_id = $eventWidget['event_id'];
        
        $widgetTypes= WidgetTypes::all();
        
        $event = Events::where('event_id', $event_id)->where('deleted', 0)->first();

        $eventWidgets = EventWidgets::where('event_id', $event_id)->where('deleted', 0)->get()->first();

        
        $url1 = Storage::disk('public')->url('uploads/bookseries/'.$event_id.'/'.'widgets/'.$eventWidget->img);

        $url = array(
            'widget_img'     => $url1
            );

        return view('admin.events.bookseries.widgets.edit')->with(
            array(
                'event_id' => $event_id,
                'event' => $event,
                'eventWidget' => $eventWidget,
                'widgetTypes' => $widgetTypes,
                'eventWidgets' => $eventWidgets,
                'url' => $url
                
                ));
    }
    
    


    public function store(Request $request, $event_id)
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
            //new Bookseries Widgets
            // Store the new bookseries widgets data...
            $imageName = 'widget_'.substr(md5(microtime()),0,4).'.jpg';
            $id = EventWidgets::create(array(
                'widget_type_id' => $data['widget_type_id'],
                'position' => $data['position'],
                'img' => $imageName,
                'img_url' => $data['img_url'],
                'widget_title' => $data['widget_title'],
                'widget_description' => $data['widget_description'],
                'event_id' => $event_id
            ));

            if($id)
            {
                
                // checking file is valid.
                if ($request->hasFile('widget_img')  &&  $request->file('widget_img')->isValid()) 
                {
                    $img = $request->file('widget_img');
                    $destinationPath = 'uploads/bookseries/'.$event_id.'/'.'widgets/'; // upload path
                    $extension = $img->getClientOriginalExtension(); // getting image extension
                    $fileName = $imageName;//$extension; // renameing image
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('widget_img')->getRealPath()));
                  // sending back with message
                }

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
            //Update Bookseries Widgets
            // Update the bookseries widgets data...
            $idu = EventWidgets::where('event_widget_sid', $id)->update(array(
                
                'widget_type_id' => $data['widget_type_id'],
                'position' => $data['position'],
                'widget_title' => $data['widget_title'],
                'img_url' => $data['img_url'],
                'widget_description' => $data['widget_description']
                
            ));
            $widget = EventWidgets::where('event_widget_sid', $id)->first();
            if($widget->img == ''){
                $imageName = 'widget_'.substr(md5(microtime()),0,4).'.jpg';
            }else{
                $imageName = $widget->img;
            }

            if($idu)
            {
                 

                if ($request->hasFile('widget_img')  &&  $request->file('widget_img')->isValid()) {
                    $widgetImg = $request->file('widget_img');
                    $destinationPath = 'uploads/bookseries/'.$widget->event_id.'/'.'widgets/'; // upload path
                    $extension = $widgetImg->getClientOriginalExtension(); // getting image extension
                    $fileName = $imageName;//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('widget_img')->getRealPath()));
                  // sending back with message
                }
                return Response::json($idu);
            }
        }
    }
/*
 public function update(Request $request, $id)
    {

    $data = $request->all();
    

    // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'title_en' => 'required|max:255',
            'title_ar' => 'max:255',
            'slug' => 'required|max:255|unique:events,slug,'.$id.',event_id',
            'cover_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'slider_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'list_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'featured_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'email' => 'required|email|max:255',
            'location_en' => 'max:255',
            'location_ar' => 'max:255',
            'event_master_id' => 'not_in:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
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
            $sYear = date("Y" ,strtotime($data['start_date']));
            $ifSubCategory = SubCategory::where('title', $sYear)->first();
            if($ifSubCategory === null)
            {
                $subCategoryNew = SubCategory::create(array(
                    'category_id' => 1,
                    'title' => $sYear
                ));
                $subCategoryId= $subCategoryNew->id;
            }
            else
            {
                $subCategoryId = $ifSubCategory->sub_category_id;
            }
            //update Bookseries
            // Store the updated bookseries data...
            $idu = Events::where('event_id', $id)->update(array(
                'category_id' => 1,
                'sub_category_id' => $subCategoryId,
                'title_en' => $data['title_en'],
                'title_ar' => $data['title_ar'],
                'email' => $data['email'],
                'slug' => $data['slug'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'location_en' => $data['location_en'],
                'location_ar' => $data['location_ar'],
                'event_master_id' => $data['event_master_id'],
                'publish' => @$data['publish'],
                'submission' => @$data['submission'],
                'fullpaper' => @$data['fullpaper']
            ));

            //upload images if exists
            if($idu)
            {
                // checking file is valid.
                if ($request->hasFile('cover_img')  &&  $request->file('cover_img')->isValid()) {
                    $coverImg = $request->file('cover_img');
                    $destinationPath = 'uploads/bookseries/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/cover_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('cover_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('list_img')  &&  $request->file('list_img')->isValid()) {
                    $coverImg = $request->file('list_img');
                    $destinationPath = 'uploads/bookseries/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/list_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('list_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('slider_img')  &&  $request->file('slider_img')->isValid()) {
                    $coverImg = $request->file('slider_img');
                    $destinationPath = 'uploads/bookseries/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/slider_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('slider_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('featured_img')  &&  $request->file('featured_img')->isValid()) {
                    $coverImg = $request->file('featured_img');
                    $destinationPath = 'uploads/bookseries/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/featured_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('featured_img')->getRealPath()));
                  // sending back with message
                }

            }
            return Response::json($idu);
        }

    }
*/
    public function destroy($id)
    {
        $delete = EventWidgets::where('event_widget_sid', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = EventWidgets::where('event_widget_sid', $id)->update(array(
                'deleted' => 0,
                ));
    }
}
