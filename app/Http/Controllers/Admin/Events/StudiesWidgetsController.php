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

class StudiesWidgetsController extends Controller
{
    //
    public function show($event_id)
    {
        $event = Events::where('event_id', $event_id)->firstOrFail();
        $eventTitle = $event['title_en'];
    	$widgets = EventWidgets::where('event_id', $event_id)->where('deleted','=', 0)->get();

        return view('admin.events.conference.widgets.show')->with(
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
                $widgets = EventWidgets::where('deleted', '=', 0)->where('event_id', $event_id)->get();
                return View('admin.events.conference.widgets.show')->with(array('widgets' => $widgets) )->with('select','active-only')->with('event_id', $event_id)->with(array(
            'event' => $eventTitle));
            break;
            case "inactive-only";
                $widgets = EventWidgets::where('deleted', '=', 1)->where('event_id', $event_id)->get();
                return View('admin.events.conference.widgets.show')->with(array('widgets' => $widgets) )->with('select','inactive-only')->with('event_id', $event_id)->with(array(
            'event' => $eventTitle));
            break;
            case "all";
                $widgets = EventWidgets::where('event_id', $event_id)->get();
                return View('admin.events.conference.widgets.show')->with(array('widgets' => $widgets) )->with('select','all')->with('event_id', $event_id)->with(array(
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
        return view('admin.events.conference.widgets.create')->with(
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

        
        $url1 = Storage::disk('public')->url('uploads/conferences/'.$event_id.'/'.'widgets/'.$eventWidget->img);

        $url = array(
            'widget_img'     => $url1
            );

        return view('admin.events.conference.widgets.edit')->with(
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
            //new Conference Widgets
            // Store the new conference widgets data...
            if($request->hasFile('widget_img'))
            {
                $imageName = 'widget_'.substr(md5(microtime()),0,4).'.jpg';
            }
            else
            {
                $imageName = '';
            }
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
                    $destinationPath = 'uploads/conferences/'.$event_id.'/'.'widgets/'; // upload path
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
            //Update Conference Widgets
            // Update the conference widgets data...
            $widget = EventWidgets::where('event_widget_sid', $id)->first();
            if($widget->img == ''){
                $imageName = 'widget_'.substr(md5(microtime()),0,4).'.jpg';
            }else{
                $imageName = $widget->img;
            }
            $idu = EventWidgets::where('event_widget_sid', $id)->update(array(
                
                'widget_type_id' => $data['widget_type_id'],
                'position' => $data['position'],
                'widget_title' => $data['widget_title'],
                'img_url' => $data['img_url'],
                'widget_description' => $data['widget_description'],
                'img'   =>  $imageName
                
            ));

            if($idu)
            {
                 

                if ($request->hasFile('widget_img')  &&  $request->file('widget_img')->isValid()) {
                    $widgetImg = $request->file('widget_img');
                    $destinationPath = 'uploads/conferences/'.$widget->event_id.'/'.'widgets/'; // upload path
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
