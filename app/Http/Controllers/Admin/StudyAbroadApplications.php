<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Requests;

use App\Http\Controllers\Controller;

use DB;

use Session;


use App\Models\StudyAbroadApplication;



use Carbon\Carbon;

use Auth;

use Response;

class StudyAbroadApplications extends Controller
{
 
    public function index()
    {
       $applications = StudyAbroadApplication::get();
             
     return view('admin/studyAbroadApplications/index')->with('applications', $applications);
    }
    
    public function search()
    {
        $searchOptions = Request()->get("search", array());
        
        $start = Request()->get("start", 0);
        $draw = Request()->get("draw",1);
        $length = Request()->get("length",1);
        $pageNumber = ($start/$length) +1;

          if(!empty($searchOptions)){
            $searchString = $searchOptions['value'];
            if (\DateTime::createFromFormat('Y-m-d', $searchString) == FALSE) {
            $keyword = $searchString;

            }else{
                $date = date("Y-m-d", strtotime($searchString));
           }
        }
        
        
        $query = StudyAbroadApplication::query()
        ->orderBy('created_at', 'DESC')
        ->join('events', 'study_abroad_applications.app_event_id', '=', 'events.event_id')
        ->join('sub_category', 'study_abroad_applications.app_sub_category', '=', 'sub_category.sub_category_id')
        ->select('study_abroad_applications.*','events.title_en','sub_category.title');       
        
        $countOfHostssWithoutFilter = $query->count();

        $allApps = $query->count();
        
        if(isset($keyword)){
            $query->select('study_abroad_applications.*','events.title_en','sub_category.title')
                    ->orWhere("events.title_en", "like", "%".$keyword."%")
                   ->orWhere("sub_category.title", "like", "%".$keyword."%")
                    ->orWhere("study_abroad_applications.app_undersigned_name", "like", "%".$keyword."%")
                    ->orWhere("study_abroad_applications.app_city", "like", "%".$keyword."%");                    
              
        }
        
          if(isset($date)){
             $query->whereDate("study_abroad_applications.app_date_birth_day", "=", $date);
        }
        
        $apps = $query->paginate($length, ['*'],'page', $pageNumber);
        
      
        $appsTable = $this->drawTheHostsDataTable($apps);
    
   
        return response()->json(
                array(
                    'data' => $appsTable,
                    'recordsTotal' => $countOfHostssWithoutFilter,
                    'recordsFiltered' => $allApps,
                    'draw' => $draw));
                
 
    }
    
  public function drawTheHostsDataTable($apps){
        $appsArray = array();
    
        foreach($apps as $app){
            $appArray = array();
            
            $appArray['app_id']= $app->app_id;
            $appArray['event_name']= $app->title_en;
            $appArray['category_name']= $app->title;
            $appArray['surname']= $app->app_undersigned_name;
            $appArray['city']= $app->app_city;
            $appArray['date_of_birth']= date('Y-m-d', strtotime($app->app_date_birth_day));
            
            $appsArray[] = $appArray;
            }
            return $appsArray;
        }
        
         public function show ($id)
     {
         $appsData = StudyAbroadApplication::where('app_id',$id)
                 ->join('events', 'study_abroad_applications.app_event_id', '=', 'events.event_id')
                 ->join('sub_category', 'study_abroad_applications.app_sub_category', '=', 'sub_category.sub_category_id')
                 ->first();

         return view('admin/studyAbroadApplications/show')->with('data', $appsData);
     }
    

}
