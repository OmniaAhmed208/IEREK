<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Events;
use App\Models\EventFees;
use App\Models\Users;
use App\Models\EventAttendance;
use App\Models\EventFullPaper;
use App\Models\Orders;
use App\Models\OrderLines;
use App\Models\Notifications;
use App\Models\VisaRequests;
use Helper;

use Auth;
use App\User;
use Response;
use Twocheckout;
use JWTAuth;
use App\Models\Accommodations;
use App\Models\EventImportantDate;
use App\Models\UserType;
use App\Payment\Twocheckout_Charge;
use App\Payment\Twocheckout_Error;
use App\Repositories\Eloquent\PromoCodeRepository as PromoCode; 
use App\Repositories\Eloquent\OrderRepository as Order;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class PaymentController extends Controller
{
    
        
    /**
     * @var Actor
     */
    private $promoCode;
    private $order;

    public function __construct(PromoCode $promoCode, Order $order) {

        $this->promoCode = $promoCode;
        $this->order = $order;
    }

    //
    public function index($slug){
        $event = Events::where('slug', $slug)->first();
        $event_id = $event['event_id'];
        $iDates = EventImportantDate::where('event_id',$event['event_id'])->get();
        $aIDates = [];
        $curDate = [0];
        $withPromoCode = false;
        if(count($iDates) > 0){
            $idate = 1;
            foreach($iDates as $date){
                $aIDates[$date['event_date_type_id']] = date('Y-m-d', strtotime($date['to_date']));
            }
        }else{
            $idate = 0;
        }
        $sd = $event->start_date; $ed = $event->end_date; $cd = date('Y-m-d');
        if($event->category_id != 1){
            $idate = 1;
        }
        //if event has been finished
        if($idate == 0 || $cd > @$aIDates[11] && $event->category_id == 1){
            return redirect('/events/'.$slug);
        }else{
            if($event->category_id == 1){
                if($cd <= @$aIDates[5]){
                    //if today is less than the early payments date
                    $curDate = [0,1,2,3,4,5];
                }elseif($cd > @$aIDates[5] && $cd <= @$aIDates[6]){
                    //if today is between the early pay date and the regular payment date
                    $curDate = [0,6];
                    $withPromoCode = true;
                }elseif($cd > @$aIDates[6] && $cd <= @$aIDates[7]){
                     //if today is between the regular pay date and the late payment date
                    $curDate = [0,7];
                    $withPromoCode = true;
                }elseif($cd > @$aIDates[7]){
                    //if today greater than late payment date
                    $curDate = [];
                    $withPromoCode = true;
                }
            
            } else {
                $curDate = [0];
            }
            if(Auth::check()){
                $isRegistered = EventAttendance::where('event_id', $event_id)->where('user_id', Auth::user()->user_id)->first();
                $userNat = Users::where('user_id', Auth::user()->user_id)->first();
                //if the user country is egypt and the event supoorts LE currency
                if($userNat->countries->name == "Egypt" && $event->egy == 1 && $event->category_id == 1){
                    $event['currency'] = 'EGP';
                }
                if($isRegistered){
                    $evAttID = $isRegistered['event_attendance_id'];
                    $type = $isRegistered['event_attendance_type_id']; // audiance or outher or co-outher

                    //check for done payments
                    // $order = Orders::where('user_id',Auth::user()->user_id)->whereHas('payment_id', function($q){$q->where('status', '=', 1);});
                    $attPaid = EventAttendance::user(Auth::user()->user_id)->event($event_id)
                            ->first();
                    
                    $accPaid = Accommodations::getAccommodationOfEvent($evAttID, $event_id);
                    
                    $viPaid = VisaRequests::getVisaRequestsOfuserInEvent($evAttID, $event_id);

                    $attfees = [];
                     if($attPaid['payment'] !== 1) //if user paid the attendace fees on office or via back account
                     {
                         $attfees = EventFees::getFeesOfAttendanceForAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );
                     }
                   if(count($accPaid) > 0){ // if user pay the accommodation on office or via bank account
                        $accfees = [];
                        
                    }else{
                    $accfees = EventFees::getFeesOfAccommodationForAudienceOnAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );
                    
                    }
                    
                    if(count($viPaid) > 0){
                        $vifees = [];
                        
                    }else{
                        $vifees = EventFees::getFeesOfvISAForAudienceOnAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );
                    }
//                    $pubfees = EventFees::getFeesOfPublishingForAudienceOnAllPaymentTypes(
//                            $event_id, 
//                            $curDate, 
//                            $type, 
//                            $event['currency']
//                            );
                    $paperfees = EventFees::getFeesOfPaperForAudienceOnAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );
                    
                    $shortpaperfees = EventFees::getFeesOfShortPaperForAudienceOnAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );
                    
                    $cusfees = EventFees::getFeesOfCustomForAudienceOnAllPaymentTypes(
                            $event_id, 
                            $curDate, 
                            $type, 
                            $event['currency']
                            );


                    $user = Users::where('user_id', Auth::user()->user_id)->first();
                    $papers = EventFullPaper::where('author_id', $user['user_id'])->where('paid', 0)->where('status','!=', 4)->where('event_id',$event_id)->get();
                    $promoCode = null;
                    if($withPromoCode || $user->user_type_id == UserType::scientific_committee){
                      $promoCode = $this->promoCode->getValidPromoCodeBy(array(
                        'user_id' => $user->user_id,
                        "event_id" => $event_id
                    ));  
                    }
                    
                    return view('payment.index')->with(array(
                        "event"         => $event,
                        "user"          => $user,
                        "attfees"       => $attfees,
                        "accfees"       => $accfees,
                        "vifees"        => $vifees,
//                        "pubfees"       => $pubfees,
                        "paperfees"     => $paperfees,
                        "papers"        => $papers,
                        "cusfees"       => $cusfees,
                        "type"          => $type,
                        "promoCode"     => $promoCode,
                        "shortpaperfees" => $shortpaperfees
                    ));
                }else{
                    return redirect('/events/'.$event['slug']);
                }   
            }else{
                return redirect('/events/'.$event['slug']);
            }
        }
    }

    public function custom($slug,$amount){
        $event = Events::where('slug', $slug)->first();

        return view('payment.custome')->with(['event' => $event,'amount' => $amount]);        
    }

    public function mobile($slug, Request $request){

        $event = Events::where('event_id', $slug)->first();
        $event_id = $event['event_id'];
        $slug = $event['event_id'];
        $iDates = EventImportantDate::where('event_id',$event['event_id'])->get();
        $aIDates = [];
        $curDate = [0];
        JWTAuth::setToken($request['_token']);
        $token = JWTAuth::getToken();
        $user = JWTAuth::decode($token);
        $member = User::find($user['sub']);
        //ore use your own way to get the user
        Auth::login($member);
        if(count($iDates) > 0){
            $idate = 1;
            foreach($iDates as $date){
                $aIDates[$date['event_date_type_id']] = date('Y-m-d', strtotime($date['to_date']));
            }
        }else{
            $idate = 0;
        }
        $sd = $event->start_date; $ed = $event->end_date; $cd = date('Y-m-d');
        if($event->category_id != 1){
            $idate = 1;
        }
        $sd = $event->start_date; $ed = $event->end_date; $cd = date('Y-m-d');
        if($idate == 0 || $cd > @$aIDates[11] && $event->category_id == 1){
            dd('Error occured, please contact us Error: (#NP185)');
        }else{
            if($event->category_id == 1){

                if($cd < @$aIDates[5]){
                    $curDate = [0,1,2,3,4,5];
                }elseif($cd > @$aIDates[5] && $cd < @$aIDates[6]){
                    $curDate = [0,6];
                }elseif($cd > @$aIDates[6] && $cd < @$aIDates[7]){
                    $curDate = [0,7];
                }elseif($cd > @$aIDates[7]){
                    $curDate = [];
                }
            
            } else {
                $curDate = [0];
            }
            if(Auth::check()){
                $isRegistered = EventAttendance::where('event_id', $event_id)->where('user_id', Auth::user()->user_id)->first();
                $userNat = Users::where('user_id', Auth::user()->user_id)->first();
                if($userNat['country_id'] == 64 && $event->egy == 1 && $event->category_id == 1){
                    $event['currency'] = 'EGP';
                }
                if(count($isRegistered) > 0){
                    $evAttID = $isRegistered['event_attendance_id'];
                    $type = $isRegistered['event_attendance_type_id'];
                    //check for done payments
                    // $order = Orders::where('user_id',Auth::user()->user_id)->whereHas('payment_id', function($q){$q->where('status', '=', 1);});
                    $attPaid = EventAttendance::where('user_id',Auth::user()->user_id)->where('event_id',$event_id)->first();
                    $accPaid = Accommodations::where('event_attendance_id',$evAttID)->where('event_id',$event_id)->where('paid', 1)->get();
                    $viPaid = VisaRequests::where('event_attendance_id',$evAttID)->where('event_id',$event_id)->where('paid', 1)->get();

                    $attfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 1)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
                    if($attPaid['payment'] == 1){$attfees = [];}
                    $accfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 2)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
                    if(count($accPaid) > 0){$accfees = [];}
                    $vifees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 3)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
                    if(count($viPaid) > 0){$vifees = [];}
                    $pubfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 4)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
                    $paperfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 5)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
                    $cusfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 6)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();


                    $user = Users::where('user_id', Auth::user()->user_id)->first();
                    $papers = EventFullPaper::where('author_id', $user['user_id'])->where('paid', 0)->where('status','!=', 4)->get();
                    return view('payment.mobile')->with(array(
                        "event"         => $event,
                        "user"          => $user,
                        "attfees"       => $attfees,
                        "accfees"       => $accfees,
                        "vifees"        => $vifees,
                        "pubfees"       => $pubfees,
                        "paperfees"     => $paperfees,
                        "papers"        => $papers,
                        "cusfees"       => $cusfees,
                        "type"          => $type
                    ));
                }else{
                    // return redirect('/error/register');
                    dd('Error occured, please contact us Error: (#RE205)');
                }   
            }else{
                // return redirect('/error/auth');
                dd('Error occured, please contact us Error: (#AU505)');
            }
        }
    }

    public function addpay(Request $request)
    {
        $data = $request->all();
        $name = $data['add_name'];
        $email = $data['add_email'];
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            die('Please enter a vaild email address.');
        }
        $type = $data['add_type'];
        $event_id = $data["event_id"];
        $event = Events::where('event_id', $event_id)->first();
        $user = Users::where('email', $email)->first();
        $user_id = $user['user_id'];
        $iDates = EventImportantDate::where('event_id',$event_id)->get();
        $aIDates = [];
        if(count($iDates) > 0){
            $idate = 1;
            foreach($iDates as $date){
                $aIDates[$date['event_date_type_id']] = date('Y-m-d', strtotime($date['to_date']));
            }
        }else{
            $idate = 0;
        }
        $sd = $event->start_date; $ed = $event->end_date; $cd = date('Y-m-d');
        if($idate == 0 || $cd > $aIDates[8]){
            die('Can not pay now');
        }
        $curDate = [0];
        if($cd < $aIDates[5]){
            $curDate = [0,5];
        }elseif($cd > $aIDates[5] && $cd < $aIDates[6]){
            $curDate = [0,6];
        }elseif($cd > $aIDates[6] && $cd < $aIDates[7]){
            $curDate = [0,7];
        }elseif($cd > $aIDates[7]){
            $curDate = [];
        }

        if($user){
            if($user->user_id == Auth::user()->user_id){
                die('This is email belongs to your user account.');
            }
            if(strlen($name) < 3){
                die('Please enter a correct name for attendance.');
            }
            $isRegistered = EventAttendance::where('event_id', $event_id)->where('user_id', $user->user_id)->first();
            $papers =[];
            if($isRegistered){
                $evAttID = $isRegistered['event_attendance_id'];
                $attPaid = EventAttendance::where('event_attendance_id',$evAttID)->where('event_id',$event_id)->where('payment', 1)->get();
                $accPaid = Accommodations::where('event_attendance_id',$evAttID)->where('event_id',$event_id)->where('paid', 1)->get();
                $viPaid = VisaRequests::where('event_attendance_id',$evAttID)->where('event_id',$event_id)->where('paid', 1)->get();

                $curType = $isRegistered['event_attendance_type_id'];
                if($type != $curType){
                    // $type = $curType;
                    if($curType == 3 && $type != 3)
                    {
                        die('The user you are trying to add is currently registered as Author.!<br>Please choose Author and try again.');
                    }elseif($type == 3 && $curType != 3){
                        die('The user you are trying to add is not registered as Author.!<br>Please choose the right type and try again.');
                    }elseif($type == 2 && $curType != 2){
                        die('The user you are trying to add is registered as Co-Author.!<br>Please choose Co-Author and try again.');
                    }
                }
                $papers = EventFullPaper::where('author_id', $user_id)->where('paid', 0)->where('status','<', 4)->get();
            }else{
                if($type > 1)
                {
                    die('The user you are trying to add is not registered at this event.!<br>Please choose Audience and try again.');
                }
                $attPaid = [];
                $accPaid = [];
                $viPaid = [];
            }
            $user['type'] = $type;
        }else{
            $user = array(
                'first_name'    => $name,
                'email'         => $email,
                'type'          => $type,
                'country_id'    => 0
            );
            $papers =[];
            $attPaid = [];
            $accPaid = [];
            $viPaid = [];

        }
        $userNat = Users::where('user_id', Auth::user()->user_id)->first();
        if($userNat['country_id'] == 64 && $event->egy == 1){
            if($user['country_id'] != 64){
                die("You can't pay for this user (ERROR #02)");
            }
            $event['currency'] = 'EGP';
        }else{
            if($user['country_id'] == 64 && $event->egy == 1){
                die("You can't pay for this user (ERROR #03)");
            }
        }
        if($user['type'] == 3){
            $attfees = [];
        }else{
            $attfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 1)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
            if(count($attPaid) > 0){$attfees = [];}
        }
        $accfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 2)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
        if(count($accPaid) > 0){$accfees = '';}
        $vifees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 3)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
        if(count($viPaid) > 0){$vifees = '';}
        $pubfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 4)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
        $paperfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 5)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();
        $cusfees = EventFees::where('event_id',$event_id)->whereIn('event_date_type_id', $curDate)->whereIn('event_attendance_type_id', [0,$type])->where('fees_category_id', 6)->where('currency',$event['currency'])->where('amount','>=', 1)->where('deleted', 0)->get();


        return Response(json_encode(array(
            "user"          => $user,
            "attfees"       => $attfees,
            "accfees"       => $accfees,
            "vifees"        => $vifees,
            "pubfees"       => $pubfees,
            "paperfees"     => $paperfees,
            "papers"        => $papers,
            "cusfees"       => $cusfees
        )));
    }

    public function view()
    {
        return view('pay');
    }

    public function store(Request $request)
    {

    }


    public function cPay(Request $request)
    {

        $merchantOrderId = rand(0,999999);
        $data = $request->all();
        
        //oldd checkout 
        Twocheckout::privateKey('31E89BEB-92B8-44F7-826C-5F9AA0C1815E');
        Twocheckout::sellerId('102563668');
        Twocheckout::username('ierek-dev');
        Twocheckout::password('Ierek@6155');
        
//        
//       Twocheckout::privateKey('31E89BEB-92B8-44F7-826C-5F9AA0C1815E');
//       Twocheckout::sellerId('102563668');
//       Twocheckout::username('ierek-dev');
//       Twocheckout::password('Samaa@012345@ierek@@dev');
//        Twocheckout::verifySSL(true);
        
        
        //sandbox
//        Twocheckout::privateKey('31BB4A9B-3642-4F17-B58D-38265E9F2F24');
//        Twocheckout::sellerId('901381413');
//        Twocheckout::username('samaa_mohamed');
//        Twocheckout::password('Ierek@6155');
//        Twocheckout::verifySSL(false);
//        Twocheckout::sandbox(true);
        
        
        try {
            $charge = Twocheckout_Charge::auth(array(
                "merchantOrderId" => $merchantOrderId,
                "token" => $data['token'],
                "currency" => $data['currency'],
                "total" => $data['amount'],
                "billingAddr" => array(
                    "name" => $data['name'],
                    "addrLine1" => $data['caddress'],
                    "city" => $data['city'],
                    "state" => $data['state'],
                    "zipCode" => $data['zip'],
                    "country" => $data['country'],
                    "email" => $data['email'],
                    "phoneNumber" => $data['phone']
                )
            ), 'array');
            if ($charge['response']['responseCode'] == 'APPROVED') {
                $e = "APPROVED";

                $event_id = $data['event_id'];
                $user_id  = Auth::user()->user_id;
                $parent_id  = Auth::user()->user_id;


                //Get Attendance ID using $user_id
                
                @$attendanceID = EventAttendance::where('user_id',$user_id)->where('event_id',$event_id)->first();
                $att_id = $attendanceID['event_attendance_id'];

                if(count($attendanceID) > 0){
                   $register = EventAttendance::where('event_attendance_id', $att_id)->update(array('unregistered' => 0));
                }else{
                    $register = EventAttendance::create(array(
                        "event_id"                  => $event_id,
                        "user_id"                   => $user_id,
                        "event_attendance_type_id"  => 1
                    ));
                    $att_id = $register->id;
                }

                //Create Order
                $order = Orders::create([
                    "event_attendance_id" => $att_id,
                    "event_id" => $event_id,
                    "parent_id" => $parent_id,
                    "payment_id" => $merchantOrderId,
                    "order_type" => '1',
                    "status" => "Pending",
                    "total" => $data['amount'],
                    "currency" => $data['currency']
                ]);

                $oid = $order->id;
                 if($oid)
                 {
               EventAttendance::where('user_id',$user_id)->where('event_id',$data['event_id'])->update([
                            'payment' => 1
                        ]);
                 } 
                $mail = curl_init('https://www.ierek.com/mail_send?event='.$event_id.'&abstract=&paper=&order='.$oid.'&template=5&user_id='.Auth::user()->user_id);
                curl_exec($mail);

                $notification = Notifications::create(array(
                    'title' => 'Payment Done',
                    'description' => 'Your payment was done successfully, we will notify you once we have approved your payment, thank you.',
                    'user_id' => Auth::user()->user_id,
                    'color' => 'green',
                    'type' => 'payment-Done',
                    'icon' => 'dollar',
                    'timeout' => 25000,
                    'url' => '/billing',
                    'status' => 'info'
                ));
            }
        } catch (Twocheckout_Error $e) {
            $e->getMessage();
        }


        return Response($e);
            
    }


    public function pay(Request $request)
    {
        $merchantOrderId = rand(0,999999);
        $data = $request->all();
        
       Twocheckout::privateKey('31E89BEB-92B8-44F7-826C-5F9AA0C1815E');
       Twocheckout::sellerId('102563668');
       Twocheckout::username('ierek-dev');
       Twocheckout::password('NFYyGMPhtZ8RKmRh');
       Twocheckout::verifySSL(true);
       
       //old checkout data 
//        Twocheckout::privateKey('31E89BEB-92B8-44F7-826C-5F9AA0C1815E');
//        Twocheckout::sellerId('102563668');
//        Twocheckout::username('ierek-dev');
//        Twocheckout::password('Ierek@6155');
        
       //sandbox
//        Twocheckout::privateKey('31BB4A9B-3642-4F17-B58D-38265E9F2F24');
//        Twocheckout::sellerId('901381413');
//        Twocheckout::username('samaa_mohamed');
//        Twocheckout::password('Ierek@6155');
//        Twocheckout::verifySSL(false);
//        Twocheckout::sandbox(true);
        
        
        try {
            $charge = Twocheckout_Charge::auth(array(
                "merchantOrderId" => $merchantOrderId,
                "token" => $data['token'],
                "currency" => $data['currency'],
                "total" => $data['amount'],
                "billingAddr" => array(
                    "name" => $data['name'],
                    "addrLine1" => $data['caddress'],
                    "city" => $data['city'],
                    "state" => $data['state'],
                    "zipCode" => $data['zip'],
                    "country" => $data['country'],
                    "email" => $data['email'],
                    "phoneNumber" => $data['phone']
                )
            ), 'array');
            
            if ($charge['response']['responseCode'] == 'APPROVED') {
                 $e = "APPROVED";
              $this->paying($data,$merchantOrderId);
            }
        } catch (Twocheckout_Error $e) {
            $e->getMessage();
            // $e = $data['address'];
        }


        return Response($e, 200);
    }
    
    public function payBank(Request $request)
    {

        $data = $request->all();
        $merchantId = 0;
        $this->paying($data,$merchantId);
    }
    
    public function paying($data,$merchantOrderId)
    {
        if($data['paymentType'] == 2)
        {

            $payment = 1;
             $paid = 1;
        }
        else
        {

        $payment = 0;
        $paid = 0;
        }



                @$names = array_merge($data['names']);
                @$emails = array_merge($data['emails']);
                @$unique_ids = array_merge($data['unique_id']);
                @$attendance = array_merge($data['attendance']);
                @$afees = array_merge($data['afees']);
                @$accommodation = array_merge($data['accommodation']);
                @$visa = array_merge($data['visa']);
                @$vfees = array_merge($data['vfees']);
                @$paper = array_merge($data['paper']);
                @$publish = array_merge($data['publish']);
                @$custom = array_merge($data['cus']);
                @$fname = array_merge($data['fname']);
                @$mname = array_merge($data['mname']);
                @$lname = array_merge($data['lname']);
                @$passport = array_merge($data['passport']);
                @$issued_at = array_merge($data['issued_at']);
                @$expires_on = array_merge($data['expires_on']);
                @$address = array_merge($data['address']);
                @$empassy_address = array_merge($data['empassy_address']);
                @$additional_info = array_merge($data['additional_info']);
                $event_id = $data['event_id'];
                $parent_id  = Auth::user()->user_id;
                $promoCode = isset($data['promo_code']) ? $data['promo_code'] : null;

                for($i = 0; $i < count($names); $i++)
                {
                    $total = 0;
                    $user = Users::where('email', $emails[$i])->first();
                    $unique_id = $unique_ids[$i];
                    if($user)
                    {
                        $user_id = $user['user_id'];
                    }else{
                        $user_id = 0;
                    }

                    if($data['paymentType'] != '2')
                    {
                        $this->ExistingOrder($user_id, $event_id,$data['paymentType']);
                    }

                    //Get Attendance ID using $user_id
                    @$attendanceID = EventAttendance::where('user_id',$user_id)->where('event_id',$event_id)->first();
                    $att_id = $attendanceID['event_attendance_id'];

                    //Create Order
                    $order = $this->order->create([
                        "event_attendance_id" => $att_id,
                        "event_id" => $event_id,
                        "parent_id" => $parent_id, // eli dafe3 el folos
                        "payment_id" => $merchantOrderId, //want to send it from its action
                        "order_type" => $data['paymentType'],
                        "total" => $data['amount'],
                        "status" => "Pending",
                        'currency' => $data['currency']
                    ]);

                    $oid = $order->id;








                    if(isset($attendance[$i])){
                        $attendanceFees = EventFees::where('event_fees_id',$attendance[$i])->first();

                        $payAtt = EventAttendance::where('user_id',$user_id)->where('event_id',$data['event_id'])->update([
                            'payment' => $payment
                        ]);
                        $oline = OrderLines::create([
                            "order_id" => $oid,
                            "user_id" => $user_id,
                            "event_fees_id" => $attendanceFees['event_fees_id'],
                            "amount" => $attendanceFees['amount'],
                            "currency" => $attendanceFees['currency']
                        ]);

                        $total = $total + $attendanceFees['amount'];
                    }
                    if($afees[$i] == 1){
                        $accommodationFees = EventFees::where('event_fees_id',$accommodation[$i])->first();

                         Accommodations::create([
                            'paid' => $paid,'event_attendance_id' => $att_id,
                            'event_id' => $event_id,
                            'event_fees_id' => $accommodationFees['event_fees_id']
                        ]);
                        $oline = OrderLines::create([
                            "order_id" => $oid,
                            "user_id" => $user_id,
                            "event_fees_id" => $accommodationFees['event_fees_id'],
                            "amount" => $accommodationFees['amount'],
                            "currency" => $accommodationFees['currency']
                        ]);
                        $total = $total + $accommodationFees['amount'];
                    }
                    if($vfees[$i] == 1){
                        $visaFees = EventFees::where('event_fees_id',$visa[$i])->first();

                        VisaRequests::create([
                            'paid' => $paid,
                            'event_attendance_id'   => $att_id,
                            'event_id'              => $event_id,
                            'fname'                 => $fname[$i],
                            'mname'                 => $mname[$i],
                            'lname'                 => $lname[$i],
                            'passport_no'           => $passport[$i],
                            'issued_at'             => $issued_at[$i],
                            'expires_on'            => $expires_on[$i],
                            'address'               => $address[$i],
                            'empassy_address'       => $empassy_address[$i],
                            'additional'            => $additional_info[$i]
                        ]);
                        $oline = OrderLines::create([
                            "order_id" => $oid,
                            "user_id" => $user_id,
                            "event_fees_id" => $visaFees['event_fees_id'],
                            "amount" => $visaFees['amount'],
                            "currency" => $visaFees['currency']
                        ]);
                    }
                    if(isset($paper)){

                        for($p = 0; $p < count($paper); $p++){
                            $aPaper = explode('_',trim($paper[$p]));
                            $aPublish = explode('_',trim($publish[$p]));
                            $paperFees = EventFees::where('event_fees_id',$aPaper[1])->first();
                            $paperFeesDiscount = $p >0 ? ($paperFees['amount'] * PromoCode::MORE_THAN_ONE_PAPER_DISCOUNT / 100) : 0;
                            $publishFees = EventFees::where('event_fees_id',$aPublish[1])->first();
                            $totamount = ($paperFees['amount'] - $paperFeesDiscount) + $publishFees['amount'];
                            $fullPaper = EventFullPaper::where('paper_id',$aPaper[0])->where('author_id',$user_id)->first();
                            if($fullPaper){
                                EventFullPaper::where('paper_id',$fullPaper['paper_id'])->update([
                                    'paid' => $paid
                                ]);
                                $oline = OrderLines::create([
                                    "order_id" => $oid,
                                    "user_id" => $user_id,
                                    "event_fees_id" => $paperFees['event_fees_id'],
                                    "amount" => $totamount,
                                    "currency" => $paperFees['currency'],
                                    "paper_id" => $aPaper[0]
                                ]);
                                $total = $total + $totamount;
                            }
                        }
                    }

                    if(isset($custom)){
                        for($c = 0; $c < count($custom); $c++){
                            $aCustom = explode('_',trim($custom[$c]));
                            if($unique_id == $aCustom[0]){
                                $cusfees = EventFees::where('event_fees_id',$aCustom[1])->first();
                                if($cusfees){
                                   $oline = OrderLines::create([
                                    "order_id" => $oid,
                                    "user_id" => $user_id,
                                    "amount" => $cusfees['amount'],
                                    "event_fees_id" => $cusfees['event_fees_id'],
                                    "currency" => $cusfees['currency'],
                                ]);
                                $total = $total + $cusfees['amount'];
                                }
                            }
                        }
                    }

                    if(isset($data['promo_code'])){
                        //get promo code
                        //create one order line
                        //update the orders with the new total amount
                        $promoCode = $this->promoCode->getValidPromoCodeBy(array(
                        'user_id' => $parent_id,
                        "event_id" => $event_id,
                        "promo_code" => $data['promo_code']
                       ));
                        if($promoCode){
                            $discountAmount = ($total * $promoCode['discount_amount']) / 100;
                            $total = $total - $discountAmount;
                            $oline = OrderLines::create([
                                    "order_id" => $oid,
                                    "user_id" => $parent_id,
                                    "amount" =>  $discountAmount,
                                    "currency" => $data['currency'],
                                ]);
                             $this->order->update([
                                 'total' => $total,
                                 'currency' => $data['currency']
                             ], $oid, 'order_id');

                             $this->promoCode->update(array("is_valid" => 0), $promoCode->id);
                        }

                    }




                    $mail = curl_init('https://www.ierek.com/mail_send?event='.$event_id.'&abstract=&paper=&order='.$oid.'&template=5&user_id='.Auth::user()->user_id);
                    curl_exec($mail);

                    $notification = Notifications::create(array(
                        'title' => 'Payment Done',
                        'description' => 'Your payment was done successfully, we will notify you once we have approved your payment, thank you.',
                        'user_id' => Auth::user()->user_id,
                        'color' => 'green',
                        'type' => 'payment-Done',
                        'icon' => 'dollar',
                        'timeout' => 25000,
                        'url' => '/billing',
                        'status' => 'info'
                    ));
                }



        $barcode = Users::barcodeGenerator($oid);




//
//        $data  = array('blade-path' => 'mail.payment-mail',
//            'to'=>'ayousry943@gmail.com',
//            'from'=>'info@irek.com',
//            'cc'=>'test@irek.com',
//            'subject'=>'IEREK Confirmation Bayment ',
//            'barcode'=> $barcode,
//
//
//        );
//
//        return  Helper::sendmail($data);


            
    }
    
    public function ExistingOrder($user_id,$event_id,$paymenttType)
    {
           //Get Attendance ID using $user_id
          @$attendanceID = EventAttendance::where('user_id',$user_id)->where('event_id',$event_id)->first();
          $att_id = $attendanceID['event_attendance_id'];
                     
           //check if this order to this user created before
            @$OrderData = Orders::where('parent_id',$user_id)->where('event_id',$event_id)->where('order_type',$paymenttType)->where('status',"Pending")->first();
            
            if($OrderData['order_id'] != NULL)
            {
          //if order is existed before we remove this order to create another
          //make sure if there is accommadtion to this order or not
          @$AccomadationData = Accommodations::where('event_attendance_id',$att_id)->where('event_id',$event_id)->where('paid',0)->first();
    
          if($AccomadationData['accommodation_id'] != NULL)
          {
             //if there is accomadation to this order before (delete it)
             Accommodations::where('event_attendance_id',$att_id)->where('event_id',$event_id)->where('paid',0)->delete();  
          }
          
          //-----------------------------------------------------------------------------//
          
          //make sure if there is visa to this order or not
          @$VisaData = VisaRequests::where('event_attendance_id',$att_id)->where('event_id',$event_id)->where('paid',0)->delete();
    
          if($VisaData['visa_id'] != NULL)
          {
              //if there is visa to this order before (delete it)
              VisaRequests::where('event_attendance_id',$att_id)->where('event_id',$event_id)->where('paid',0)->first();
          }
          //-----------------------------------------------------------------------------//
          
          //delete order and its ordel list
              OrderLines::where('order_id', $OrderData['order_id'] )->delete();  
              Orders::where('order_id', $OrderData['order_id'] )->delete();  
              
          }
           //----------------------------------------------------------------------------//     
    }
    
    public function checkPromoCode($promoCode, $eventId){
        $userId = Auth::user()->user_id;
        $promoCodeObject = $this->promoCode->getValidPromoCodeBy(array(
            "user_id" => $userId,
            "event_id" => $eventId,
            "promo_code" => $promoCode
        ));
        
        if($promoCodeObject){
            return array("success" => true, "promocode" => $promoCodeObject);
        }
        
        return array("success" => false);
    }
}

