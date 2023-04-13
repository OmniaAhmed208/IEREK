<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Requests;

use App\Http\Controllers\Controller;

use DB;

use Session;


use App\Models\HostConference;



use Carbon\Carbon;

use Auth;

use Response;

class HostConferenceController extends Controller
{
 
    public function index()
    {
       $hostsConference = HostConference::get();
             
     return view('admin/hostConferences/index')->with('hosts', $hostsConference);
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
        
        
        $query = HostConference::query()
        ->orderBy('created_at', 'DESC')
        ->select('host_conference.*');       
        
        $countOfHostssWithoutFilter = $query->count();

        $allHosts = $query->count();
        
        if(isset($keyword)){
            $query->select("host_conference.*")
                    ->orWhere("host_university", "like", "%".$keyword."%")
                    ->orWhere("host_contact_name", "like", "%".$keyword."%")
                    ->orWhere("host_contact_email", "like", "%".$keyword."%")
                    ->orWhere("host_location", "like", "%".$keyword."%")
                    ->orWhere("host_budget", "like", "%".$keyword."%");                    
              
        }
        
         if(isset($date)){
             $query->whereDate("created_at", "=", $date);
        }
        
        $hosts = $query->paginate($length, ['*'],'page', $pageNumber);
        
      
        $hostsTable = $this->drawTheHostsDataTable($hosts);
    
   
        return response()->json(
                array(
                    'data' => $hostsTable,
                    'recordsTotal' => $countOfHostssWithoutFilter,
                    'recordsFiltered' => $allHosts,
                    'draw' => $draw));
                
 
    }
    
     public function drawTheHostsDataTable($hosts){
        $hostsArray = array();
    
        foreach($hosts as $host){
            $hostArray = array();
            
            $hostArray['host_id']= $host->host_id;
            $hostArray['host_university']= $host->host_university;
            $hostArray['host_contact_name']= $host->host_contact_name;
            $hostArray['host_contact_email']= $host->host_contact_email;
            $hostArray['host_location']= $host->host_location;
            $hostArray['host_budget']= $host->host_budget;
            $hostArray['created_at']= date('Y-m-d', strtotime($host->created_at));
            
            $hostsArray[] = $hostArray;
            }
            return $hostsArray;
        }
        
     public function show ($id)
     {
         $hostsConferenceData = HostConference::where('host_id',$id)->first();

         return view('admin/hostConferences/show')->with('data', $hostsConferenceData);
     }
    

}
