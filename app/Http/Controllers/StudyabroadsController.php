<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\SubCategory;
use App\Models\EventAttendance;
use App\Models\StudyAbroadApplication;
use App\Models\Events;
use App\Models\MailTemplates;
use Session;
use Mail;
use DB;


class StudyabroadsController extends Controller
{
    public function index()
    {

        $studyabroadYears  = DB::table('sub_category')
                ->select('sub_category.*')
                ->where('category_id', '=', 3)
                ->where('deleted', '=', 0)
                ->get();
        $eventLists = DB::table('events')
                ->select('events.*')
                ->where('category_id', '=', 3)
                ->where('publish', '=', 1)
                ->where('deleted', '=', 0)
                ->get();
      
        return view('studyabroads')
                ->with('studyabroadYears', $studyabroadYears)
                ->with('eventLists', $eventLists);
    }
    
    public function showApplication($event,$cat,$sub)
    {
        return view('application')
                ->with('event',$event)
                ->with('category',$cat)
                ->with('sub_category',$sub);
    }
    
    public function storeApplication(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
           'app_undersigned_name' => 'required',
           'app_date_birth_day' => 'required',
           'app_city' => 'required',
           'app_state' => 'required',
           'app_state_of_residence' => 'required',
           'app_permanent_address' => 'required',
           'app_email' => 'required|email',
           'app_signature' => 'required',
          
    ]);
       
         $eventName = Events::where('event_id',$data['app_event_id'])->value('title_en');
  
         $formApp= StudyAbroadApplication::create($request->all());  
       
          if($formApp)
           {
               $from = $data['app_email'];
               $email = "study.abroad@ierek-scholar.org";
               $cc = "info@ierek-scholar.org";
//               
          

    
     Mail::send('mail.studyAbroad_application',
       ['eventName'=> $eventName,'app_undersigned_name' => $data['app_undersigned_name'], 
        'app_date_birth_day' => $data['app_date_birth_day'],'app_city' => $data['app_city'],'app_state' => $data['app_state'],
        'app_state_of_residence' => $data['app_state_of_residence'], 'app_permanent_address' => $data['app_permanent_address'],
        'app_email'=>$data['app_email'],'app_signature' => $data['app_signature']
       ],function ($message) use ($cc,$email,$from)
                {
                    $message->from($from);

                    $message->to($email);
                    $message->cc($cc);
                    $message->subject('IEREK - Studyabroad Application');

                });
                
                
         }
         
        Session::flash("message", "Your request has been submitted successfully!");
         return redirect('study_abroad/application_view/'.$data['app_event_id'].'/'.$data['app_category'].'/'.$data['app_sub_category']);
        
    }
}
