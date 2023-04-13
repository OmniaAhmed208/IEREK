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

use App\Models\Partners;

use Storage;
use Validator;
use Response;

class PartnersController extends Controller
{
    //
    public function index()
    {
         $partners = Partners::all();
         
        //echo "in index";
        return view('admin.pages.home.partners.index')->with(array(
            'partners'  => $partners
        ));
            
    }
    
    public function create()
    {
       return view('admin.pages.home.partners.create');
    }
    
    public function store(request $request) {

    //echo "in store";
        
    $input=$request->all();
    
    $images=array();
    
     
     $this->validate($request, [
          'images.*' => 'required|mimes:jpg,jpeg,png',
      ]);
     
     
    if($files=$request->file('images')){
        foreach($files as $file){
            $originalName=$file->getClientOriginalName();
            $extenstion = $file->guessClientExtension();
            $code = sha1($originalName).strtoupper(substr(md5(microtime()),0,4));
            $fileName = $code.".".$extenstion;
//            $file->move('image',$fileName);
            $images[]=$fileName;
            $destinationPath = 'uploads/partners/'; // upload path
   Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($file->getRealPath()));

        }
    }
    //print_r($images);
    /*Insert your data*/
 
    foreach ($images as $img)
    {
        partners::insert( [
        'img_path'=>  $img,
        
    ]);

    }
     return redirect()->route('indexPartners');
}

    public function destroy($id)
    {
        $delete = partners::where('id', $id)->delete();
    }
}
      

