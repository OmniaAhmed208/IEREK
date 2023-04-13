<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\SubCategory;
use App\Models\EventAttendance;
use App\Models\HostConference;
use App\Models\MailTemplates;
use DB;
use Mail;
use Session;
use \App\Models\conference_link_out;
use \App\Models\Events;


 
class ConferencesController extends Controller
{
    public function index()
    {

       
      $event_link_out  =  Events::with('get_conference_link_out')->get();

//dd($event_link_out->first()->get_conference_link_out());

//       ->exists())
// echo print_r($event_link_out->first()->get_conference_link()->first()->id);
     // dd($event->first()->get_conference_link()->first()->conference_link);

        
        $conferenceYears  = DB::table('sub_category')
                ->select('sub_category.*')
                ->where('category_id', '=', 1)
                ->orderBy('title','ASC')
                ->get();
        $eventLists = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 1)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->where('start_date','>=',date('Y-m-d'))
                ->orderBy('start_date')
                ->get();
                // dd($eventLists);

                
      
        $finished = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 1)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->where('start_date','<',date('Y-m-d'))
                ->orderBy('start_date')
                ->get();
        return view('conferences')
                ->with('conferenceYears', $conferenceYears)
                ->with('eventLists', $eventLists)
                ->with('finished', $finished)
                ->with('event_link_out',$event_link_out)
                ->with('eventsCount',1);
    }
//    public function index()
//    {
//     
//         $eventListsCountYearly = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->whereYear('start_date','=',date('Y'))
//                ->get()
//                ->count();
//         
//                  $finishedEventsCount = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->whereYear('start_date','=',date('Y'))
//                ->where('end_date','<',date('Y-m-d'))
//                ->get()
//                ->count();
//         
//      
//       
//         if($eventListsCountYearly == $finishedEventsCount)
//         {
//          $conferenceYears  = DB::table('sub_category')
//                ->select('sub_category.*')
//                ->where('category_id', '=', 1)
//                ->where('title','>=', date('Y')+1)
//                ->orderBy('title','ASC')
//                ->get();   
//          $eventListsCount = 0;
//         }
//        else 
//         {
//           $conferenceYears  = DB::table('sub_category')
//                ->select('sub_category.*')
//                ->where('category_id', '=', 1)
//                ->where('title','>=', date('Y'))
//                ->orderBy('title','ASC')
//                ->get(); 
//           $eventListsCount = 0;
//         }
//         
//         
//
//        $eventLists = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->where('start_date','>=',date('Y-m-d'))
//                ->orderBy('start_date')
//                ->get();
//      
//        $finished = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->where('start_date','<',date('Y-m-d'))
//                ->orderBy('start_date')
//                ->get();
//        return view('conferences')
//                ->with('conferenceYears', $conferenceYears)
//                ->with('eventLists', $eventLists)
//                ->with('finished', $finished)
//                ->with('eventsCount', $eventListsCount);
//    }
//    
//    public function previous()
//    {
//        $eventListsCountYearly = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->whereYear('start_date','=',date('Y'))
//                ->get()
//                ->count();
//         
//                  $finishedEventsCount = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->whereYear('start_date','=',date('Y'))
//                ->where('end_date','<',date('Y-m-d'))
//                ->get()
//                ->count();
//         
//      
//       
//         if($eventListsCountYearly == $finishedEventsCount)
//         {
//           $conferenceYears  = DB::table('sub_category')
//                ->select('sub_category.*')
//                ->where('category_id', '=', 1)
//                ->where('title','<', date('Y')+1)
//                ->orderBy('title','ASC')
//                ->get();
//           $eventListsCount = 0;
//         }
//        else 
//         {
//          $conferenceYears  = DB::table('sub_category')
//                ->select('sub_category.*')
//                ->where('category_id', '=', 1)
//                ->where('title','<', date('Y'))
//                ->orderBy('title','ASC')
//                ->get();
//           $eventListsCount = 1;
//         }
//         
//        
//        $eventLists = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->where('start_date','>=',date('Y-m-d'))
//                ->orderBy('start_date')
//                ->get();
//      
//        $finished = DB::table('events')
//                ->select('events.*')
//                ->where('category_id', '=', 1)
//                ->where('publish', '=', 1)
//                ->where('deleted', '=', 0)
//                ->where('start_date','<',date('Y-m-d'))
//                ->orderBy('start_date')
//                ->get();
//        return view('previous_conferences')
//                ->with('conferenceYears', $conferenceYears)
//                ->with('eventLists', $eventLists)
//                ->with('finished', $finished)
//                ->with('eventsCount', $eventListsCount);
//    }
    
    public function advancedSeriesConf(){
         $conferenceYears  = DB::table('sub_category')
                ->select('sub_category.*')
                ->where('category_id', '=', 1)
                ->orderBy('title','ASC')
                ->get();
        $eventLists = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 1)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->where('start_date','>=',date('Y-m-d' ,strtotime("2018-12-05")))
                ->where('end_date','<=',date('Y-m-d' ,strtotime("2018-12-07")))
                ->orderBy('start_date')
                ->get();

        return view('conf-series')
                ->with('conferenceYears', $conferenceYears)
                ->with('eventLists', $eventLists);
    }
    
    public function hostConf(){
        return view('hostConference/hostConf');
    }
    
    public function store(Request $request)
    {
          $data = $request->all();
        
        $this->validate($request, [
           'host_university' => 'required',
           'host_contact_name' => 'required',
           'host_contact_email' => 'required|email',
           'host_contact_affliation' => 'required',
           'host_conference_overview' => 'required',
           'host_residential_overview' => 'required',
           'host_catering' => 'required',
           'host_location' => 'required',
           'host_conference_program' => 'required',
           'host_budget' => 'required',
    ]);
       
          $hosting = HostConference::create($request->all());  
          
          if($hosting)
           {
               $from = $data['host_contact_email'];
               $email = "info@ierek.com";
               
          

    
     Mail::send('mail.host-a-conference-email-template',
       ['host_university' => $data['host_university'],'host_contact_name' => $data['host_contact_name'], 
        'host_contact_email' => $data['host_contact_email'],'host_contact_affliation' => $data['host_contact_affliation'],
        'host_conference_overview' => $data['host_conference_overview'], 'host_residential_overview' => $data['host_residential_overview'],
        'host_catering'=>$data['host_catering'],'host_location' => $data['host_location'],'host_conference_program'=>$data['host_conference_program'],'host_budget'=>$data['host_budget']
       ],function ($message) use ($email,$from)
                {
                    $message->from($from);

                    $message->to($email);

                    $message->subject('IEREK - Request Host Conference');

                });
                
                
         }
         Session::flash("message", "Your request has been submitted successfully!");
         return redirect('host_conference');
                 
    }

}
