<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Contact;
use App\Models\Messages;
use App\Models\Users;
use App\Models\EventAttendance;
use App\Models\Orders;
use App\Events;
use App\Models\Notifications;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     
    public function __construct()
    {
        if(UserSession::user()->user_type == 1) {
            return redirect('welcome');
        }
        if(UserSession::user()->user_type == 2){
            return redirect('admin');
        }
        if(UserSession::user()->user_type == 3){
            return redirect('admin');
        }
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //
    public function index()
    {
        $contact = Messages::where('read', 0)->where('user_id',Auth::user()->user_id)->get();
        $notifications = Notifications::where('read', 0)->where('user_id',Auth::user()->user_id)->get();
        $date = date('Y-m-d 00:00:00', strtotime("-1 week +1 day"));
        $users = Users::where('created_at','>=' , $date)->get();
        $conf = EventAttendance::whereHas('events',function($q){$q->where('category_id', 1);})->where('created_at','>=' , $date)->get();
        $wor = EventAttendance::whereHas('events',function($q){$q->where('category_id', 2);})->where('created_at','>=' , $date)->get();
        $stu = EventAttendance::whereHas('events',function($q){$q->where('category_id', 3);})->where('created_at','>=' , $date)->get();
        $torders = Orders::where('created_at','>=' , $date)->get();
    	return view('admin.home')->with(array(
            'dashboard' => true,
            'messages' => count($contact),
            'notifications' => count($notifications),
            'users' => count($users),
            'cConferences' => count($conf),
            'cWorkshops' => count($wor),
            'cStudy' => count($stu),
            'cPayments' => count($torders)
        ));
    }

    public function logs()
    {
        $cats = Notifications::where('type','!=', NULL)->orderBy('type','asc')->groupBy('type')->get();
        return view('admin.logs')->with(array(
            'cats' => $cats
        ));
    }
}
