<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\Staffs;
use App\Models\FeaturedEvents;
use App\Models\Slider;
use App\Models\Events;
use App\Models\Users;
use App\Models\EventFees;
use App\Models\StaticPages;
use App\Models\EventFullPaper;
use App\Models\EventAttendance;
use App\Models\VisaRequests;
use App\Models\Videos;
use App\Models\EventSection;
use App\Models\EventWidgets;
use App\Models\Announcements;
use Session;
use Storage;
use Input;
use App\Models\Orders;
use App\Models\OrderLines;
use App\Models\StudyApplication;
use App\Models\Notifications;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use \App\Models\Partners;

class HomeController extends Controller
{

    public function test(Request $request)
    {
        
     

 	/*$fullpapers = EventFullPaper::all();
        foreach($fullpapers as $p){
            $toAuthor = EventAttendance::where('event_id',$p->event_id)->where('user_id',$p->author_id)->update([
                'event_attendance_type_id' => 3
            ]);
            echo 'done event:'.$p->event_id.' user:'.$p->author_id.'<br>';
        }*/ 
           
    }
    //
    public function index()
    {
        $sliders = Slider::where('deleted',0)->get();
        $f_conferences = FeaturedEvents::where('category_id',1)->where('deleted',0)->whereHas('event', function($q){
            $q->where('publish', '=', 1);
        })->orderBy('position')->take(6)->get();
        $f_summer_schools = FeaturedEvents::whereIn('category_id', [3,4])->where('deleted',0)->whereHas('event', function($q){
            $q->where('publish', '=', 1);
        })->orderBy('position')->take(3)->get();
    	$videos = Videos::where('deleted',0)->orderBy('position','ASC')->get();
        $partners = Partners::all();
        $announcements = Announcements::where('announce_active',0)->orderBy('announce_position','ASC')->limit(4)->get();
        return View('welcome')->with(array(
            'sliders' => $sliders,
            'f_conferences' => $f_conferences,
            'f_summer_schools' => $f_summer_schools,
            'videos'    => $videos,
            'partners'  => $partners,
            'announcements' => $announcements
        ));
    }

    public function remember(Request $request)
    {
        //echo $request['url'];
        if(isset($_COOKIE['merem'])) {
            $token = $_COOKIE['merem'];
            $user = Users::where('remember_token',$token)->first();
            if(count($user) > 0){
                // create user session
                session_start();
                Session::put('user_id', $user['user_id']);
                Session::put('first_name', $user['first_name']);
                Session::put('user_type', $user['user_type_id']);
                Session::flash('status','Welcome back '.$user['first_name'].'!');
                $length = rand(10,99);
                $token = bin2hex(random_bytes($length));
                $remember = Users::where('user_id',$user['user_id'])->update(array(
                    'remember_token' => $token
                ));
                setcookie(
                  "merem",
                  $token,
                  time() + (10 * 365 * 24 * 60 * 60)
                );
            }
            else
            {
                Session::flush();
                    setcookie(
                      "merem",
                      "",
                      time() + (-3600)
                    );
            }
        }
        return redirect(url($request['url'])); 
    }

    public function contact_us()
    {
        $content = StaticPages::where('type','contact')->first();
        return view('contact')->with(array(
            'content' => $content
        ));
    }

    public function about_us()
    {
        $content = StaticPages::where('type','about')->first();
        return view('about')->with(array(
            'content' => $content
        ));
    }

    public function ierek_press()
    {
//        $content = StaticPages::where('type','press')->first();
//        return view('press')->with(array(
//            'content' => $content
//        ));
        
        return redirect('http://press.ierek.com/');
    }

    public function faq()
    {
        $content = StaticPages::where('type','faq')->first();
        return view('faq')->with(array(
            'content' => $content
        ));
    }

    public function calendar()
    {
        $date = date('Y-m');
        $events = Events::where('deleted', 0)->groupBy('start_date')->get();
        $allevents = Events::where('deleted', 0)->where('publish',1)->where('start_date','LIKE','%'.$date.'%')->get();
        $years = [];
        foreach($events as $event){
            array_push($years, substr($event['start_date'], 0,4));
        }

        $years = array_unique($years);
        return view('calendar')->with(array(
            'years' => $years,
            'events' => $allevents
        ));
    }

    public function translation_service()
    {
        $content = StaticPages::where('type','translation_service')->first();
        return view('translation_service')->with(array(
            'content' => $content
        ));
    }

    public function terms()
    {
        $content = StaticPages::where('type','terms')->first();
        return view('terms')->with(array(
            'content' => $content
        ));
    }

    public function careers()
    {
        $content = StaticPages::where('type','careers')->first();
        return view('careers')->with(array(
            'content' => $content
        ));
    }

    public function feedback()
    {
        $content = StaticPages::where('type','feedback')->first();
        return view('feedback')->with(array(
            'content' => $content
        ));
    }

    public function suggest()
    {
        $content = StaticPages::where('type','suggest')->first();
        return view('suggest')->with(array(
            'content' => $content
        ));
    }

    public function undergraduate_studies()
    {
        $event = Events::where('event_id', 333)->where('publish',1)->first();
        $isregs = 0;
        if(Auth::check()){ 
            $user_id = Auth::user()->user_id;
            $isreg = EventAttendance::where("event_id", $event["event_id"])->where("user_id", $user_id)->where('unregistered', 0)->first();   
            if(count($isreg) > 0){
                $isregs = 1;
            }
        }
        $sections = EventSection::where('event_id', $event['event_id'])->orderBy('position')->get();
        $fees = EventFees::where('event_id', $event['event_id'])->orderBy('fees_category_id','ASC')->orderBy('event_attendance_type_id','ASC')->orderBy('event_date_type_id','ASC')->get();
        $widgets = EventWidgets::where('event_id', $event['event_id'])->where('deleted',0)->orderBy('position')->get();
        $postpone = EventAttendance::where('event_id',$event['event_id'])->where('user_id',@Auth::user()->user_id)->where('unregistered', 0)->first();
        if($isregs == 0)
        {
            $isdate = date('Y-m-d');
        }
        else
        {
            $isdate = $postpone['postpone'];
        }
        $now = date("Y-m-d h:i:s");

        return view('undergraduate_studies')->with(array(
            'event' => $event,
            'sections' => $sections,
            'widgets' => $widgets,
            'fees' => $fees,
            'isreg' => $isregs,
            'postpone' => @$isdate,
            'paid'    => $postpone['payment']
        ));
    }

    public function postgraduate_studies()
    {
        $event = Events::where('event_id', 444)->where('publish',1)->first();
        $isregs = 0;
        if(Auth::check()){ 
            $user_id = Auth::user()->user_id;
            $isreg = EventAttendance::where("event_id", $event["event_id"])->where("user_id", $user_id)->where('unregistered', 0)->first();   
            if(count($isreg) > 0){
                $isregs = 1;
            }
        }
        $sections = EventSection::where('event_id', $event['event_id'])->orderBy('position')->get();
        $fees = EventFees::where('event_id', $event['event_id'])->orderBy('fees_category_id','ASC')->orderBy('event_attendance_type_id','ASC')->orderBy('event_date_type_id','ASC')->get();
        $widgets = EventWidgets::where('event_id', $event['event_id'])->where('deleted',0)->orderBy('position')->get();
        $postpone = EventAttendance::where('event_id',$event['event_id'])->where('user_id',@Auth::user()->user_id)->where('unregistered', 0)->first();
        if($isregs == 0)
        {
            $isdate = date('Y-m-d');
        }
        else
        {
            $isdate = $postpone['postpone'];
        }
        $now = date("Y-m-d h:i:s");

        return view('postgraduate_studies')->with(array(
            'event' => $event,
            'sections' => $sections,
            'widgets' => $widgets,
            'fees' => $fees,
            'isreg' => $isregs,
            'postpone' => @$isdate,
            'paid'    => $postpone['payment']
        ));
    }

    public function studies_register(Request $request)
    {
        $event_id = $request['event_id'];

        unset($request['event_id']);
        unset($request['_token']);
        $application = json_encode($request->all(),true);
        $data = StudyApplication::create([
            'user_id' => auth()->user()->user_id,
            'event_id'  => $event_id,
            'application'   => $application
        ]);

        $user_id = Auth::user()->user_id;
        $check = EventAttendance::where("event_id", $event_id)->where("user_id", $user_id)->first();
        $event = Events::where('event_id', $event_id)->first();
        if(count($check) > 0){
           $register = EventAttendance::where('event_attendance_id', $check->event_attendance_id)->update(array('unregistered' => 0));
        }else{
            $register = EventAttendance::create(array(
                "event_id"                  => $event_id,
                "user_id"                   => $user_id,
                "event_attendance_type_id"  => 1
            ));
        }
        $user = Users::where('user_id', $user_id)->first();
        $template = 14;
        $mail = curl_init(url('mail_send?event='.$event_id.'&abstract=&paper=&template='.$template.'&user_id='.Auth::user()->user_id));
        curl_exec($mail);

        Session::flash('payment', $event->event_id);

        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            if($users[$x]['user_id'] == Auth::user()->user_id){
                $createdBy = 'You';
            }else{
                $createdBy = Auth::user()->first_name;
            }
            $notification = Notifications::create(array(
                'title' => 'New '.$event->title_en.' Application By '.$createdBy,
                'description' => $event->title_en.' has new application submitted by '.$createdBy,
                'user_id' => $users[$x]['user_id'],
                'color' => 'brown',
                'type' => 'studies-submitted',
                'icon' => 'graduation-cap',
                'timeout' => 5000,
                'url' => '/admin/events/studies/application/'.$event_id,
                'status' => 'info'
            ));
        }

        return response()->json([
            'success' => true
        ]);

    }

    public function sc()
    {
        $scs = Users::where('user_type_id',1)->where('hidden','!=',1)->where('deleted',0)->orderBy('first_name','ASC')->get();
        $content = StaticPages::where('type','sc')->first();
        return View('sc')->with(array(
            'scs' => $scs,
            'content' => $content
        ));
    }
    
    public function study_abroad_intro()
    {
        $content = StaticPages::where('type','study_abroad_intro')->first();
        return view('study_abroad_intro')->with(array(
            'content' => $content
        ));
    }

    public function conference_proceedings()
    {
        $content = StaticPages::where('type', 'conference_proceedings')->first();
        return view('conference_proceedings')->with(array(
            'content' => $content
        ));
    }

    public function projects_managemnet()
    {
        $content = StaticPages::where('type', 'projects_managemnet')->first();
        return view('projects_managemnet')->with(array(
            'content' => $content
        ));
    }

    public function scientists_forum()
    {
        $content = StaticPages::where('type', 'scientists_forum')->first();
        return view('scientists_forum')->with(array(
            'content' => $content
        ));
    }

    public function sc_profile($slug)
    {
        $user = Users::where('user_type_id',1)->where('deleted',0)->where('slug',$slug)->first();
        if($user){
            return View('sc_profile')->with(array(
                'user' => $user
            ));
        }else{
            return redirect('/');
        }
    }

    public function logout()
    {
        setcookie(
          "merem",
          "",
          time() + (-3600)
        );
        Session::flush();
    	return redirect('/');
    }


    //
    public function billing()
    {
        $events = Events::all();
        $user_id = auth()->user()->user_id;
        $orders = Orders::where('parent_id',$user_id)->orderBy('created_at','DESC')->paginate(10);
        foreach($orders as $order){
            $orderLines = OrderLines::where('order_id', $order['order_id'])->get();
            $count = 0;
            $curr = null;
            foreach($orderLines as $oLine){
                $count = $count + $oLine['amount'];
                $curr = $oLine['currency'];
            }
            $order['amount'] = $count;
            if($order['currency'] == null){
                $order['currency'] = $curr;
            }
        }

        return View('billing')->with(array(
            'events' => $events,
            'orders' => $orders
        ));
    }
    
}
