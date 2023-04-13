<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin\Pages\Home;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EventAttendanceType;
use App\Models\EventDateType;
use App\Models\Events;
use App\Models\Videos;

use Storage;
use Validator;
use Response;

class VideoController extends Controller
{
    //
    public function index()
    {
      
        $video = Videos::where('deleted','=', 0)->orderBy('position','asc')->get();
        
        return view('admin.pages.home.video.show')->with(
            array(
            'video' => $video
            ))->with('select','active-only');
            

    }

    public function filter($deleted)
    {
        switch($deleted)
        {
            case "active-only";
                $video = Videos::where('deleted', '=', 0)->get();
                return View('admin.pages.home.video.show')->with(array('video' => $video))->with('select','active-only');
            break;
            case "inactive-only";
               $video = Videos::where('deleted', '=', 1)->get();
                return View('admin.pages.home.video.show')->with(array('video' => $video))->with('select','inactive-only');
            break;
            case "all";
                $video = Videos::all();
                return View('admin.pages.home.video.show')->with(array('video' => $video))->with('select','all');
            break;
        }
    }

    public function create()
    {
    	
        return view('admin.pages.home.video.create')->with(
            array(
            
            ));
    }

    public function edit($id)
    {
        
        $video = Videos::where('video_id', $id)->firstOrFail();
        
        
        $url1 = Storage::disk('public')->url('uploads/video/'.$video->img);

        $url = array(
            'img'     => $url1
            );

        return view('admin.pages.home.video.edit')->with(
            array(
                
                'video' => $video,
                'url' => $url
                
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
            $imageName = 'video_'.substr(md5(microtime()),0,4).'.jpg';
            $id = Videos::create(array(
                'position' => $data['position'],
                'title' => $data['title'],
                'img' => $imageName,
                'url' => $data['img_url']
            ));

            if($id)
            {
                
                // checking file is valid.
                if ($request->hasFile('img')  &&  $request->file('img')->isValid()) 
                {
                    $img = $request->file('img');
                    $destinationPath = 'uploads/video/'; // upload path
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
            $idu = Videos::where('video_id', $id)->update(array(
                
                'position' => $data['position'],
                'title' => $data['title'],
                'url' => $data['img_url']
                
            ));
            $video = Videos::where('video_id', $id)->first();
            if($video->img == ''){
                $imageName = 'video_'.substr(md5(microtime()),0,4).'.jpg';
            }else{
                $imageName = $video->img;
            }

            if($idu)
            {
                 

                if ($request->hasFile('img')  &&  $request->file('img')->isValid()) {
                    $videoImg = $request->file('img');
                    $destinationPath = 'uploads/video/'; // upload path
                    $extension = $videoImg->getClientOriginalExtension(); // getting image extension
                    $fileName = $imageName;//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('img')->getRealPath()));
                  // sending back with message
                    $updateImg = Videos::where('video_id',$id)->update(array(
                        'img' => $imageName
                    ));
                }
                return Response::json($idu);
            }
        }
    }

    public function destroy($id)
    {
        $delete = Videos::where('video_id', $id)->update(array(
                'deleted' => 1,
                ));
    }

    public function restore($id)
    {
        $delete = Videos::where('video_id', $id)->update(array(
                'deleted' => 0,
                ));
    }
}
