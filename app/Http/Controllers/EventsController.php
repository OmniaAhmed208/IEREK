<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Events;
use App\Models\Users;
use App\Models\EventFees;
use App\Models\EventSection;
use App\Models\EventWidgets;
use App\Models\EventAttendance;
use App\Models\EventTopic;
use App\Models\EventImportantDate;
use App\Models\EventSCommittee;
use App\Models\UserType;
use DB; 
use Auth;
use Session;
use Response;
use \App\Models\conference_link_out;
use App\Repositories\Eloquent\PromoCodeRepository as promoCode;

class EventsController extends Controller
{
    
    /**
     * @var Actor
     */
    private $promoCode;

    public function __construct(promoCode $promoCode) {

        $this->promoCode = $promoCode;
    }

    //
    public function show($slug)
    {



        DB::enableQueryLog();
    	$event = Events::where('slug', $slug)->where('publish',1)->where('deleted',0)->first();
        $promoCode = null;
        if(Auth::check()){ 
            $user_id = Auth::user()->user_id;
            
            $isreg = EventAttendance::where("event_id", $event["event_id"])->where("user_id", $user_id)->where('unregistered', 0)->first();   
            
            if($isreg){
                $isregs = 1;
                $promoCode = $this->promoCode->getValidPromoCodeBy(array(
                    "user_id" => $user_id,
                    "event_id" => $event["event_id"],
                    ));
            }else{
                $isregs = 0;
            }
        }else{
            $isregs = 0;
        }
        $sections = EventSection::where('event_id', $event['event_id'])->orderBy('position')->get();
        $topics = EventTopic::where('event_id', $event['event_id'])->orderBy('position')->get();
        $fees = EventFees::where('event_id', $event['event_id'])->orderBy('fees_category_id','ASC')->orderBy('event_attendance_type_id','ASC')->orderBy('event_date_type_id','ASC')->get();
        $dates = EventImportantDate::where('event_id', $event['event_id'])->get();
        $widgets = EventWidgets::where('event_id', $event['event_id'])->where('deleted',0)->orderBy('position')->get();
    	$now = date("Y-m-d");
    	
    	$effectiveDate = date('Y-m-d', strtotime("+6 months", strtotime($now)));
        
        $featured = Events::where('start_date', '>=', $effectiveDate)->where('category_id',$event['category_id'])->where('publish',1)->where('deleted',0)->orderBy('start_date')->limit(2)->get();
        $postpone = EventAttendance::where('event_id',$event['event_id'])->where('user_id',@Auth::user()->user_id)->where('unregistered', 0)->first();
        if($isregs == 0)
        {
            $isdate = date('Y-m-d');
        }
        else
        {
            $isdate = $postpone['postpone'];
        }
        if($event['category_id'] == 1 && count($sections) > 0 && count($topics) > 0)
    	{
            if($event->slug == "ebql"){
                //select head of scientific comittee user
                $headOfScien = Users::where('email','moustafa@gmail.com')->first();
            }else{
                $headOfScien = null;
            }
            $iDates = EventImportantDate::where('event_id',$event['event_id'])->get();
            $aIDates = [];
            if(count($iDates) > 0){
                $idate = 1;
                foreach($iDates as $date){
                    $aIDates[$date['event_date_type_id']] = date('Y-m-d', strtotime($date['to_date']));
                }
            }else{
                $idate = 0;
            }
            $hidden_scs = Users::where('hidden',1)->where('user_type_id',1)->get();
            $exclude = [];
            foreach($hidden_scs as $hsc){
                array_push($exclude, $hsc['user_id']);
            }
            $scs = EventSCommittee::where('event_id',$event['event_id'])->whereNotIn('user_id', $exclude)->orderBy('event_scientific_committee_id','ASC')->get();
            $ssc = [];
            foreach($scs as $ss){
                array_push($ssc, $ss['user_id']);
            }
            
    		$sc = Users::whereIn('user_id',$ssc)->orderBy('first_name','ASC')->get();
              if(date('Y', strtotime($event['start_date'])) < 2018)
              {
                 
                 return view('old-conference')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'topics' => $topics,
                'sections' => $sections,
                'fees' => $fees,
                'dates' => $dates,
                'isreg' => $isregs,
                'widgets' => $widgets,
                'scs' => $sc,
                'postpone' => @$isdate,
                'iDates' => $aIDates,
                'ifDates' => $idate,
                'paid'    => $postpone['payment'],
                'headOfScien' => $headOfScien,
                "promoCode" => $promoCode
            ));
              } 
              
              else if(date('Y', strtotime($event['start_date'])) >= 2018 && date('Y', strtotime($event['start_date'])) > 2017)
              {

                // dd($event->event_id);
                //where('id', 'LIKE', '%' . $request->search . '%')
                //$event_link_out  =  Events::with('get_conference_link_out')->get();

        $event_link_out  =  Events::where('event_id', '=',$event->event_id)->with('get_conference_link_out')->get();
        // dd($event_link_out);

               
               //dd($event_link_out->first()->get_conference_link_out()->first()->conference_link);
//  dd('here yousry');
                         return view('new-conference')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'topics' => $topics,
                'sections' => $sections,
                'fees' => $fees,
                'dates' => $dates,
                'isreg' => $isregs,
                'widgets' => $widgets,
                'scs' => $sc,
                'postpone' => @$isdate,
                'iDates' => $aIDates,
                'ifDates' => $idate,
                'paid'    => $postpone['payment'],
                'headOfScien' => $headOfScien,
                "promoCode" => $promoCode,
                'event_link_out'=>$event_link_out,
            ));
              }
              
              else if(date('Y', date('Y', strtotime($event['start_date'])) == 2021))
              {
                 
                         return view('conference')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'topics' => $topics,
                'sections' => $sections,
                'fees' => $fees,
                'dates' => $dates,
                'isreg' => $isregs,
                'widgets' => $widgets,
                'scs' => $sc,
                'postpone' => @$isdate,
                'iDates' => $aIDates,
                'ifDates' => $idate,
                'paid'    => $postpone['payment'],
                'headOfScien' => $headOfScien,
                "promoCode" => $promoCode
            ));
              }
              
              else if(date('Y/m/d',strtotime($event['created_at'])) < '2018/09/01')
              {
                   return view('new-conference')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'topics' => $topics,
                'sections' => $sections,
                'fees' => $fees,
                'dates' => $dates,
                'isreg' => $isregs,
                'widgets' => $widgets,
                'scs' => $sc,
                'postpone' => @$isdate,
                'iDates' => $aIDates,
                'ifDates' => $idate,
                'paid'    => $postpone['payment'],
                'headOfScien' => $headOfScien,
                "promoCode" => $promoCode
            ));
              }
       else {
            return view('conference')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'topics' => $topics,
                'sections' => $sections,
                'fees' => $fees,
                'dates' => $dates,
                'isreg' => $isregs,
                'widgets' => $widgets,
                'scs' => $sc,
                'postpone' => @$isdate,
                'iDates' => $aIDates,
                'ifDates' => $idate,
                'paid'    => $postpone['payment'],
                'headOfScien' => $headOfScien,
                "promoCode" => $promoCode
            ));
    	}
       }
        if($event['category_id'] == 2 && count($sections) > 0)
        {
            return view('workshop')->with(array(
                'event' => $event, 
                'featured' => $featured,
                //'topics' => $topics,
                'sections' => $sections,
                'widgets' => $widgets,
                'fees' => $fees,
                'postpone' => @$isdate,
                //'dates' => $dates,
                'isreg' => $isregs
            ));
        }
        if($event['category_id'] == 3 && count($sections) > 0)
        {
            return view('studyabroad')->with(array(
                'event' => $event, 
                'featured' => $featured,
                //'topics' => $topics,
                'sections' => $sections,
                'widgets' => $widgets,
                'fees' => $fees,
                'postpone' => @$isdate,
                //'dates' => $dates,
                'isreg' => $isregs
            ));
        }

        if($event['category_id'] == 4 && count($sections) > 0)
        {
            $hidden_scs = Users::where('hidden',1)->where('user_type_id',1)->get();
            $exclude = [];
            foreach($hidden_scs as $hsc){
                array_push($exclude, $hsc['user_id']);
            }
            $scs = EventSCommittee::where('event_id',$event['event_master_id'])->whereNotIn('user_id', $exclude)->orderBy('event_scientific_committee_id','ASC')->get();
            $ssc = [];
            foreach($scs as $ss){
                array_push($ssc, $ss['user_id']);
            }
            $sc = Users::whereIn('user_id',$ssc)->orderBy('first_name','ASC')->get();
            $book_conference = Events::where('event_id',$event['event_master_id'])->first(['slug']);
            return view('bookseries_single')->with(array(
                'event' => $event, 
                'featured' => $featured,
                'scs' => $sc,
                'master' => $book_conference,
                'widgets' => $widgets,
                'sections' => $sections
            ));
        }

        else{
            return view('errors.404');
        }


        
    }
    public function register($event_id){
        $user_id = Auth::user()->user_id;
        $user = Users::where('user_id', $user_id)->first();
        $check = EventAttendance::where("event_id", $event_id)->where("user_id", $user_id)->first();
        $isScientificCommittee = $user['user_type_id'] == UserType::scientific_committee ? true: false;
        $promoCodeArray = array();
        if($isScientificCommittee){
            $promoCodeArray = $this->promoCode->generatePromoCode($isScientificCommittee);
        }else{
            $registredBefore = EventAttendance::registeredBefore($user->user_id, $event_id)->get();
            if($registredBefore->count() > 0){
            //generate and save promocode and display it to the user
            $promoCodeArray = $this->promoCode->generatePromoCode($isScientificCommittee , $registredBefore->count());
         }
        }
        
        
        if (!empty($promoCodeArray)){
           
            $this->promoCode->create(array(
                'event_id' => $event_id,
                'user_id' => $user->user_id,
                'promo_code' => $promoCodeArray['promocode'],
                'discount_amount' => $promoCodeArray['discountAmount'],
                'is_valid' => 1,
                "expired_at" => date("Y-m-d H:i:s", strtotime('next month'))
            ));
        }
        $event = Events::where('event_id', $event_id)->first();
        if($check){
           $register = EventAttendance::where('event_attendance_id', $check->event_attendance_id)->update(array('unregistered' => 0));
        }else{
            $register = EventAttendance::create(array(
                "event_id"                  => $event_id,
                "user_id"                   => $user_id,
                "event_attendance_type_id"  => 1,
                "name" => $user->first_name." ".$user->last_name,
                "email" => $user->email
            ));
        }
        if($event['category_id'] == 1)
            {
               $template = 2;
            }
        elseif ($event['category_id'] == 2) 
            {
                    $template = 3;
            }
        elseif ($event['category_id'] == 3 && $event['sub_category_id'] != 21) 
            { 
                $template = 4;
            }
          //postgraduate  
        elseif ($event['category_id'] == 3 && $event['sub_category_id'] == 21 ) 
            { 
                $template = 15;
            }
        $mail = curl_init(url('mail_send?event='.$event_id.'&abstract=&paper=&template='.$template.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);

        Session::flash('payment', $event->event_id);
        return Response($user_id);
    }

    public function unregister($id)
    {
        $unregistered = EventAttendance::where('event_attendance_id', $id)->update(array(
            'unregistered' => 1,
            'postpone'     => NULL
        ));
        return redirect('/myevents');
    }

    public function postpone($slug)
    {
        $event = Events::where('slug',$slug)->first();
        $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 5, date('Y')));
        $postpone = EventAttendance::where('event_id',$event['event_id'])->where('user_id',Auth::user()->user_id)->update(array(
            'postpone' => $date
        ));
        return redirect('/events/'.$slug);
    }
}
