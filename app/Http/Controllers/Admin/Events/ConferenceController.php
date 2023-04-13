<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use Input;
use Storage;
use Config;
use App\Models\Events;
use App\Models\EventMaster;
use App\Models\EventAdmins;
use App\Models\EventSection;
use App\Models\Users;
use App\Models\Notifications;
use Session;
use Auth;
class ConferenceController extends Controller
{

    public function duplicate($slug){
        $event = Events::where('slug',$slug)->first();
        if($event['category_id'] == 1){
            $type = 'conference';
        }elseif($event['category_id']  == 2){
            $type = 'workshop';
        }elseif($event['category_id']  == 3){
            $type = 'studyabroad';
        }
        if(count($event) > 0){
            echo '<label style="color:red"><span class="fa fa-close"></span>  Event with Same Slug Exists <a href="/admin/events/'.$type.'/'.$event->event_id.'/edit" target="_blank">Go To Event</a></label>';
        }else{
            echo '<label style="color:green"><span class="fa fa-check"></span> Unique Slug</label>';
        }
    }
    public function index()
    {
        
      
        $admins = EventAdmins::where('user_id',Auth::user()->user_id)->get();
        $supers = Events::where('category_id',1)->get();
        $groupArray = [];
        foreach($admins as $admin){
            array_push($groupArray, $admin->event_id);
        }
        
        if(Auth::user()->user_type_id == 4){
            $groupArray = [];
            foreach($supers as $super){
                array_push($groupArray, $super->event_id);
            }
        }
        $fConferences = Events::where('deleted', '=', 0)->where('category_id',1)->whereIn('event_id', $groupArray)->get();


        return View('admin.events.conference.index')->with(array('conferences' => $fConferences));
    }
  
    public function filter($deleted)
    {
        $admins = EventAdmins::where('user_id',Auth::user()->user_id)->get();
        $supers = Events::where('category_id',1)->get();
        $groupArray = [];
        foreach($admins as $admin){
            array_push($groupArray, $admin->event_id);
        }
        if(Auth::user()->user_type_id == 4){
            $groupArray = [];
            foreach($supers as $super){
                array_push($groupArray, $super->event_id);
            }
        }
        switch($deleted)
        {
            case "active-only";
                $fConferences = Events::whereIn('event_id', $groupArray)->where('deleted', '=', 0)->where('category_id',1)->get();
                return View('admin.events.conference.index')->with(array('conferences' => $fConferences) )->with('select','active-only');
            break;
            case "inactive-only";
                $fConferences = Events::whereIn('event_id', $groupArray)->where('deleted', '=', 1)->where('category_id',1)->get();
                return View('admin.events.conference.index')->with(array('conferences' => $fConferences) )->with('select','inactive-only');
            break;
            case "all";
                    $fConferences = Events::where('category_id',1)->whereIn('event_id', $groupArray)->get();

                return View('admin.events.conference.index')->with(array('conferences' => $fConferences) )->with('select','all');
            break;
        }
    }

    public function create()
    {
        
          
        if(Auth::user()->user_type_id == 4){
            $eventmasters = EventMaster::where('deleted', 0)->get();
            $sub_categories = SubCategory::where('category_id', 1)->get();
            
           
            return View('admin.events.conference.create')->with(array('eventmasters' => $eventmasters));
        }else{
                return view('errors.404');
        }
    
    }











    //
    public function store(Request $request)
    {
        $arr_sections = array(
           '11'=> "Overview",
            '6'=>"Important Dates",
            '12' =>"Fees",
             '13' => "Scientific Committee",
            '14' => "For Authors",
            '15' => "Conference Program"
            );
        
        if(Auth::user()->user_type_id == 4){

    $data = $request->all();
    

    // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'title_en' => 'required|max:255',
            'slug' => 'required|unique:events|max:255',
            'cover_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'slider_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'list_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'featured_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'email' => 'required|email|max:255',
            'location_en' => 'max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'currency' => 'not_in:0'
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
            $ifSubCategory = SubCategory::where('title', $sYear)->where('category_id',1)->first();
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
            //new Conference
            // Store the new conference data...
            if($subCategoryId !== null)
            {
                $id = Events::create(array(
                    'category_id' => 1,
                    'sub_category_id' => $subCategoryId,
                    'title_en' => $data['title_en'],
                    'email' => $data['email'],
                    'slug' => $data['slug'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'location_en' => $data['location_en'],
                    'custome' => $data['custome'],
                    'publish' => @$data['publish'],
                    'currency' => $data['currency'],
                    // 'event_master_id' => $data['event_master_id'],
                    'submission' => @$data['submission'],
                    'fullpaper' => @$data['fullpaper'],
                    'egy' => @$data['egy'],
                    'meta_title' => @$data['meta_title'],
                    'meta_keywords' => @$data['meta_keywords'],
                    'meta_description' => @$data['meta_description'],
                    'created_by'    => Auth::user()->user_id
                ));
                if(date("Y" ,strtotime($data['start_date'])) >= "2021")
                {
                  $i = 0;
                foreach($arr_sections as $key=>$value)
                {
                    $i++;
                     EventSection::create(array(
                         'title_en' => $arr_sections[$key],
                         'event_id' => $id->id,
                         'section_type_id' => $key,
                         'position' => $i
                     ));
                }
                }
                
                $setAdmin = EventAdmins::create(array(
                    'event_id' => $id->id,
                    'user_id' => Auth::user()->user_id
                ));

                $id = $id->id;
                $users = Users::where('user_type_id','>=', 2)->get();
                $cusers = sizeof($users);
                for ($x = 0; $x < $cusers; $x++) {
                    if($users[$x]['user_id'] == Auth::user()->user_id){
                        $createdBy = 'You';
                    }else{
                        $createdBy = Auth::user()->first_name;
                    }
                    $notification = Notifications::create(array(
                        'title' => 'New Conference Created By '.$createdBy,
                        'description' => json_encode(array(
                    '<:Title:>' => '&&'.$data['title_en'].'##',
                    '<:Email:>' => '&&'.$data['email'].'##',
                    '<:URL:>' => '&&'.$data['slug'].'##',
                    '<:Start Date:>' => '&&'.$data['start_date'].'##',
                    '<:End Date:>' => '&&'.$data['end_date'].'##',
                    '<:Location:>' => '&&'.$data['location_en'].'##',
                    '<:Publish:>' => '&&'.@$data['publish'].'##',
                    '<:Currency:>' => '&&'.$data['currency'].'##',
                    '<:Submission:>' => '&&'.@$data['submission'].'##',
                    '<:Full Paper:>' => '&&'.@$data['fullpaper'].'##',
                    '<:Egyptian Fees:>' => '&&'.@$data['egy'].'##',
                    '<:Meta Title:>' => '&&'.@$data['meta_title'].'##',
                    '<:Meta Keywords:>' => '&&'.@$data['meta_keywords'].'##',
                    '<:Meta Description:>' => '&&'.@$data['meta_description'].'##'
                )),
                        'user_id' => $users[$x]['user_id'],
                        'color' => '#0090C1',
                        'type' => 'conference-create',
                        'icon' => 'bullhorn',
                        'timeout' => 5000,
                        'url' => '/admin/events/conference/'.$id.'/edit',
                        'status' => 'info'
                    ));
                }
            }

            //upload images if exists
            // checking file is valid.
            if ($request->hasFile('writing_template')  &&  $request->file('writing_template')->isValid()) {
                $coverImg = $request->file('writing_template');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/writing_template.'.$extension;//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('writing_template')->getRealPath()));
                $temname = Events::where('event_id',$id)->update([
                    'writing_template' => $fileName
                ]);
              // sending back with message
            }
            if ($request->hasFile('evaluation_sheet')  &&  $request->file('evaluation_sheet')->isValid()) {
                $coverImg = $request->file('evaluation_sheet');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/evaluation_sheet.'.'pdf';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('evaluation_sheet')->getRealPath()));
              // sending back with message
            }
            // checking file is valid.
            if ($request->hasFile('cover_img')  &&  $request->file('cover_img')->isValid()) {
                $coverImg = $request->file('cover_img');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/cover_img.'.'jpg';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('cover_img')->getRealPath()));
              // sending back with message
            }
            if ($request->hasFile('list_img')  &&  $request->file('list_img')->isValid()) {
                $coverImg = $request->file('list_img');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/list_img.'.'jpg';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('list_img')->getRealPath()));
              // sending back with message
            }
            if ($request->hasFile('slider_img')  &&  $request->file('slider_img')->isValid()) {
                $coverImg = $request->file('slider_img');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/slider_img.'.'jpg';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('slider_img')->getRealPath()));
              // sending back with message
            }
            if ($request->hasFile('featured_img')  &&  $request->file('featured_img')->isValid()) {
                $coverImg = $request->file('featured_img');
                $destinationPath = 'uploads/conferences/'.$id; // upload path
                $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                $fileName = '/featured_img.'.'jpg';//$extension; // renameing image
                //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('featured_img')->getRealPath()));
              // sending back with message
            }
            return Response::json($id);
        }
        }else{
                return view('errors.404');
        }

    }

    // edit view for conference
    public function edit($id)
    {

        if(Auth::user()->user_type_id >= 3){
        $eventmasters = EventMaster::where('deleted', 0)->get();
        $event = Events::where('event_id', $id)->first();
   
        $sub_categories = SubCategory::where('category_id', 1)->get();
        $url1 = asset('storage/uploads/conferences/'.$id.'/cover_img.jpg');
        $url2 = asset('storage/uploads/conferences/'.$id.'/list_img.jpg');
        $url3 = asset('storage/uploads/conferences/'.$id.'/slider_img.jpg');
        $url4 = asset('storage/uploads/conferences/'.$id.'/featured_img.jpg');
        $url = array(
            'cover'     => $url1,
            'list'      => $url2,
            'slider'    => $url3,
            'featured'  => $url4
            );
        return View('admin.events.conference.edit')->with('sub_categories', $sub_categories)->with('event', $event)->with('url', $url)->with('eventmasters' ,$eventmasters);
        }else{
            return view('errors.404');
        }
        
        }

    //update conference general
     public function update(Request $request, $id)
    {
         if(Auth::user()->user_type_id >= 3){

    $data = $request->all();
    

    // validating submitted data
        $validator = Validator::make($request->all(), [
            // General {  table  :  events  }
            'title_en' => 'required|max:255',
            'slug' => 'required|max:255|unique:events,slug,'.$id.',event_id',
            'cover_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'slider_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'list_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'featured_img' => 'mimes:jpeg,jpg,png|max:1000000',
            'email' => 'required|email|max:255',
            'location_en' => 'max:255',
            // 'event_master_id' => 'not_in:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'currency' => 'not_in:0'
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
            $ifSubCategory = SubCategory::where('title', $sYear)->where('category_id',1)->first();
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
            //update Conference
            // Store the updated conference data...
            $nEvent = Events::where('event_id', $id)->first();
            $idu = Events::where('event_id', $id)->update(array(
                'category_id' => 1,
                'sub_category_id' => $subCategoryId,
                'title_en' => $data['title_en'],
                'email' => $data['email'],
                'slug' => $data['slug'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'location_en' => $data['location_en'],
                'custome' => $data['custome'],
                // 'event_master_id' => $data['event_master_id'],
                'publish' => @$data['publish'],
                'currency' => $data['currency'],
                'submission' => @$data['submission'],
                'fullpaper' => @$data['fullpaper'],
                'egy' => @$data['egy'],
                'meta_title' => @$data['meta_title'],
                'meta_keywords' => @$data['meta_keywords'],
                'meta_description' => @$data['meta_description'],
                'fimage'=>@$data['fimage'],
                'simage'=>@$data['simage']
            ));

            $users = Users::where('user_type_id','>=', 2)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                if($users[$x]['user_id'] == Auth::user()->user_id){
                    $createdBy = 'You';
                }else{
                    $createdBy = Auth::user()->first_name;
                }
                $notification = Notifications::create(array(
                    'title' => 'Conference (General Information) Edited By '.$createdBy,
                    'description' => json_encode(array(
                                        '<:Title:>' => '&&'.$data['title_en'].' ## '.$nEvent['title_en'],
                                        '<:Email:>' => '&&'.$data['email'].' ## '.$nEvent['email'],
                                        '<:URL:>' => '&&'.$data['slug'].' ## '.$nEvent['slug'],
                                        '<:Start Date:>' => '&&'.$data['start_date'].' ## '.$nEvent['start_date'],
                                        '<:End Date:>' => '&&'.$data['end_date'].' ## '.$nEvent['end_date'],
                                        '<:Location:>' => '&&'.$data['location_en'].' ## '.$nEvent['location_en'],
                                        '<:Publish:>' => '&&'.@$data['publish'].' ## '.$nEvent['publish'],
                                        '<:Currency:>' => '&&'.$data['currency'].' ## '.$nEvent['currency'],
                                        '<:Submission:>' => '&&'.@$data['submission'].' ## '.$nEvent['submission'],
                                        '<:Full Paper:>' => '&&'.@$data['fullpaper'].' ## '.$nEvent['fullpaper'],
                                        '<:Egyptian Fees:>' => '&&'.@$data['egy'].' ## '.$nEvent['egy'],
                                        '<:Meta Title:>' => '&&'.@$data['meta_title'].' ## '.$nEvent['meta_title'],
                                        '<:Meta Keywords:>' => '&&'.@$data['meta_keywords'].' ## '.$nEvent['meta_keywords'],
                                        '<:Meta Description:>' => '&&'.@$data['meta_description'].' ## '.$nEvent['meta_description']
                                    )),
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'yellow',
                    'type' => 'conference-edit',
                    'icon' => 'bullhorn',
                    'timeout' => 5000,
                    'url' => '/admin/events/conference/'.$id.'/edit',
                    'status' => 'info'
                ));
            }

            //upload images if exists
            if($idu)
            {
                // checking file is valid.
                if ($request->hasFile('writing_template')  &&  $request->file('writing_template')->isValid()) {
                    $coverImg = $request->file('writing_template');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/writing_template.'.$extension;//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('writing_template')->getRealPath()));
                    $temname = Events::where('event_id',$id)->update([
                        'writing_template' => $fileName
                    ]);
                  // sending back with message
                }
                if ($request->hasFile('evaluation_sheet')  &&  $request->file('evaluation_sheet')->isValid()) {
                    $coverImg = $request->file('evaluation_sheet');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/evaluation_sheet.'.'pdf';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('evaluation_sheet')->getRealPath()));
                  // sending back with message
                }
                // checking file is valid.
                if ($request->hasFile('cover_img')  &&  $request->file('cover_img')->isValid()) {
                    $coverImg = $request->file('cover_img');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/cover_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('cover_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('list_img')  &&  $request->file('list_img')->isValid()) {
                    $coverImg = $request->file('list_img');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/list_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('list_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('slider_img')  &&  $request->file('slider_img')->isValid()) {
                    $coverImg = $request->file('slider_img');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/slider_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('slider_img')->getRealPath()));
                  // sending back with message
                }
                if ($request->hasFile('featured_img')  &&  $request->file('featured_img')->isValid()) {
                    $coverImg = $request->file('featured_img');
                    $destinationPath = 'uploads/conferences/'.$id; // upload path
                    $extension = $coverImg->getClientOriginalExtension(); // getting image extension
                    $fileName = '/featured_img.'.'jpg';//$extension; // renameing image
                    //$coverImg->move($destinationPath, $fileName); // uploading file to given path
                    Storage::disk('public')->put($destinationPath.$fileName ,file_get_contents($request->file('featured_img')->getRealPath()));
                  // sending back with message
                }

            }
            return Response::json($idu);
        }
                }else{
            return view('errors.404');
        }

    }

    public function destroy($id)
    {
        if(Auth::user()->user_type_id == 4){
        $delete = Events::where('event_id', $id)->update(array(
                'deleted' => 1,
                ));
        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            $notification = Notifications::create(array(
                'title' => 'Conference deleted By '.$createdBy,
                'description' => 'User '.$createdBy.' deleted conference',
                'user_id' => $users[$x]['user_id'],
                'color' => 'red',
                'type' => 'conference-edit',
                'icon' => 'times',
                'timeout' => 5000,
                'url' => '/admin/events/conference/'.$id.'/edit',
                'status' => 'info'
            ));
        }
        if($delete == 1)
        {
            return redirect('admin/events/conference');
        }
       }else{
            return view('errors.404');
        }
    }

    public function restore($id)
    {
        $delete = Events::where('event_id', $id)->update(array(
                'deleted' => 0,
                ));
        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            $notification = Notifications::create(array(
                'title' => 'Conference restored By '.$createdBy,
                'description' => 'User '.$createdBy.' restored conference',
                'user_id' => $users[$x]['user_id'],
                'color' => 'green',
                'type' => 'conference-edit',
                'icon' => 'undo',
                'timeout' => 5000,
                'url' => '/admin/events/conference/'.$id.'/edit',
                'status' => 'info'
            ));
        }
        if($delete == 1)
        {
            return redirect('admin/events/conference');
        }
    }
}