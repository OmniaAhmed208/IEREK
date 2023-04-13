<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin\Pages\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Support\Facades\Storage;

use Validator;
use Response;

class AnnouncementController extends Controller
{
    private $view_path = "admin.pages.home.announcement.";
    //
//    public function index()
//    {
//      
//     return view('admin.pages.home.announcement.index');
//
//    }

//    public function store(Request $request)
//    {
//        $img=$request->file('image');
//        
//        $this->validate($request, [
//          'image' => 'required|mimes:jpg,jpeg',
//         ]);
//        Storage::deleteDirectory(storage_path('uploads/announcement'));
//        //$originalName=$img->getClientOriginalName();
//        $extenstion = $img->guessClientExtension();
//        //$code = sha1($originalName).strtoupper(substr(md5(microtime()),0,4));
//        $announceName = "announcementImage.".$extenstion;
//        $destinationPath = 'uploads/announcement/'; // upload path
//        Storage::disk('public')->put($destinationPath.$announceName ,file_get_contents($img->getRealPath()));
//         
//        return redirect()->route('indexAnnouncement');
//    }
    
    public function index()
    {
        $announcements = Announcements::where('announce_active','=', 0)->get();
        
         return view('admin.pages.home.announcement.index')->with(
            array(
            'announcements' => $announcements
            ));
         
           // print_r($announcements);
    }
    
    public function create()
    {
        //echo "create your announcement";
       
       
        return view('admin.pages.home.announcement.create');
    }
    
    public function store(Request $request)
    {
        //echo "in store announcement";
        $img=$request->file('image');
        $url = $request['url'];
        
        $this->validate($request, [
          'image' => 'required|mimes:jpg,jpeg,png',
          'url'   => 'required'
         ]);
       
        $announcement_position = Announcements::max('announce_position');
        
        $originalName=$img->getClientOriginalName();
        $extenstion = $img->guessClientExtension();
        $code = sha1($originalName).strtoupper(substr(md5(microtime()),0,4));
        $announceName = $code.".".$extenstion;
        $destinationPath = 'uploads/announcement/'; // upload path
        Storage::disk('public')->put($destinationPath.$announceName ,file_get_contents($img->getRealPath()));
        
       Announcements::create(array(
                'announce_image' => $announceName,
                'announce_url'   => $url,
                'announce_active'=> 0 ,
                'announce_position' => $announcement_position+1
           
            ));
        
        return redirect()->route('indexAnnouncement');
    }
    
    public function destroy(Request $request,$announcement_id)
    {
//        /echo "in delete";

        $Announcement = Announcements::where('announce_id', $announcement_id)->first();

        Announcements::where('announce_id', $announcement_id)->update(['announce_active' => 1]);
        
        return redirect()->route('indexAnnouncement');
    }
    
    public function edit($id)
    {
         $announcement = Announcements::where("announce_id", $id)->first();
          
            return view('admin.pages.home.announcement.edit', [
                "announce_image" => $announcement['announce_image'],
                "announce_url" => $announcement['announce_url'],
                "announce_id"  => $announcement['announce_id'],
            ]);
    }
    
     public function update(Request $request)
    {
         //echo "in update";
        $img=$request->file('image');
        $url = $request['url'];
        $announce_id = $request['announce_id'];
        
          $this->validate($request, [
          'image' => 'mimes:jpg,jpeg,png',
          'url'   => 'required'
         ]);
          
          if($img == NULL)
          {
          Announcements::where('announce_id', $announce_id)->update(['announce_url' => $url]);   
          }
          else 
          {
        $originalName=$img->getClientOriginalName();
        $extenstion = $img->guessClientExtension();
        $code = sha1($originalName).strtoupper(substr(md5(microtime()),0,4));
        $announceName = $code.".".$extenstion;
        $destinationPath = 'uploads/announcement/'; // upload path
        Storage::disk('public')->put($destinationPath.$announceName ,file_get_contents($img->getRealPath()));
         Announcements::where('announce_id', $announce_id)->update(['announce_url' => $url,'announce_image' => $announceName]);  
        }
         return redirect()->route('indexAnnouncement');
    }
    
    public function order(Request $request, $id) {

        $announcement = Announcements::where('announce_id', $id)->first();
        if ($request->ajax()) {
            
            $announcements = Announcements::where("announce_id", $id)->get();

            return view($this->view_path . "includes.ajaxEdit", [
                "announcements" => $announcements,
                "announce_id" => $id,
                "announce_url" => $request['announce_url'],
                "announce_image" => $request['announce_image'],
            ]);

        }
        else{

            $announcements = Announcements::where("announce_active", 0)->orderBy('announce_position')->get();

            if (count($announcements) > 0) {
                return view($this->view_path . "order", [
                    "announcements" => $announcements,
                    "announce_id" => $id,
                    "announce_url" => $request['announce_url'],
                    "announce_image" => $request['announce_image'],
                ]);
            } else {
                return redirect(route("indexAnnouncement"));
            }
        }
    }
    
      public function changePosition(Request $request){

        if ($request->ajax()) {
            $announcement = new Announcements();
            $announcement->updatePositions($request->all()["positions"]);
        }
    }

}
