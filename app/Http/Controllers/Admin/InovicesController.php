<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Requests;

use App\Http\Controllers\Controller;

use DB;

use Session;


use App\Models\Orders;
use App\Models\Users;
use App\Models\Events;
use App\Models\Currencies;
use App\Models\Notifications;
use App\Models\EventAttendance;
use App\Models\OrderLines;
use App\Models\PromoCode;
use App\Models\Accommodations;
use App\Models\EventImportantDate;
use App\Models\VisaRequests;
use App\Models\EventFees;
use App\Models\EventFullPaper;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Crypt;

use Helper;
use Carbon\Carbon;

use Auth;

use Response;

class InovicesController extends Controller
{
 
    public function index()
    {
       

      $invoices = DB::table('orders as o')
        ->join ('users as u', 'o.parent_id', '=' , 'u.user_id')
        ->join ('events as e', 'o.event_id', '=' , 'e.event_id')
       
        ->select('o.*','u.*','e.*')
        ->get();  
             
     return view('admin/invoices/index')->with('invoices', $invoices);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
         
         $orderData = Orders::where('order_id',$id)->first();
 
         $userData = Users::where('user_id',$orderData['parent_id'])->first();
         $orderCreationDate = date("Y-m-d", strtotime($orderData['created_at']));  
         
         $allDates = EventImportantDate::where('event_id', $orderData['event_id'])->get();
         
         $earlyDate = $allDates[4]['to_date'];
         $regularDate = $allDates[5]['to_date'];
         
         if(date("Y-m-d", strtotime($earlyDate) > $orderCreationDate))
         {
            $paymentType = "Early Payment";
         }
         else if(date("Y-m-d", strtotime($regularDate) > $orderCreationDate && date("Y-m-d", strtotime($earlyDate))< $orderCreationDate ))
         {
             $paymentType = "Regular Payment";
         }
           else 
         {
             $paymentType = "Late Payment";
         }
         
   $eventsAtt = EventAttendance::AttendenceDataToInvoiceDetails($orderData['event_id'], $orderData['parent_id'])->get();
 
         foreach($eventsAtt as $eventAtt)
         {
           $eventTitle = $eventAtt['title_en'];
           $userType = $eventAtt['title'];
         }
        
        $fees = OrderLines::InvoiceDetails($id)->get();
        
         $promoCode = NULL;
         $OrderDiscount = NULL;
        foreach ($fees as $fee)
        {
            if($fee->event_fees_id == NULL)
            {
                $OrderDiscount = $fee->amount;
                $promoCode = PromoCode::where('event_id', $orderData['event_id'])->where('user_id',$orderData['parent_id'])->first(); 
            }
        }
        //--------------------------barcode generator ----------------------------//
        
        $code = Users::barcodeGenerator($orderData['order_id']);
        
         return view('admin/invoices/show')->with(array(
                'userEmail' =>$userData['email'],
                'eventId' => $orderData['event_id'],
                'amount' =>$orderData['total'],
                'currencymov' =>$orderData['currency'],
                'orderId' => $orderData['order_id'],
                'userType' =>$userType,
                'eventTitle' =>$eventTitle,
                'fees' =>$fees,
                'payment_id' => $orderData['payment_id'],
                'invoicePerioud' => $paymentType,
                'discount' => $OrderDiscount,
                'promoCode' => $promoCode['promo_code'],
                'barcode' => $code
            ));
    }
    
    public function create()
    {
        $users = Users::all();
         $dt = Carbon::now()->toDateString();
       
         $events = Events::EventsData($dt)->get(); 
              
        $currencies = Currencies::all();
       
        return View('admin/invoices/create')->with(array(
                'users' => $users,
                'events' => $events,
                'currencies' => $currencies
            )); 
    }
    
       public function save(Request $request)
    {
        //dd("in save data");
           
     $this->validate($request, [
        'email' => 'required|exists:users,email',
        'event_id' => 'required',
        'amount' => 'required|Integer',
        'currency_id' => 'required',
        'type' => 'required',
     ]);
              
        $data = $request->all();
       $userEmail=$data['email'];
       $eventId=$data['event_id'];
       $amount=$data['amount'];
       $currencyId=$data['currency_id'];
       $type=$data['type'];
       
       if($userEmail != NULL)
       {
           $userData = Users::where('email',$userEmail)->first();
           $userId = $userData['user_id'];
       }
       
           $attendanceID = EventAttendance::where('user_id',$userId)->where('event_id',$eventId)->first();
           $att_id = $attendanceID['event_attendance_id'];
                
                 if($attendanceID){
                   $register = EventAttendance::where('event_attendance_id', $attendanceID['event_attendance_id'])->update(array('unregistered' => 0));

                     $get_event_name = Events::where('event_id', $attendanceID['event_id'])->first();









                 }else{
                    $register = EventAttendance::create(array(
                        "event_id"                  => $eventId,
                        "user_id"                   => $userId,
                        "event_attendance_type_id"  => 1
                    ));
                    $att_id = $register->id;
                }




        $order = Orders::create(array(
                        "event_id"                  => $eventId,
                        "parent_id"                   => $userId,
                        "payment_id"                  => 0,
                        "event_attendance_id" => $att_id,
                        "total" =>$amount,
                        "currency" =>$currencyId,
                        "order_type" =>$type,
                        "status" =>"Approved",


                    ));


        //$barcode = Users::barcodeGenerator($order->id);

        $encrypted = Crypt::encrypt($order->id);

        $data  = array('blade-path' => 'mail.payment-mail',
            'to'=>$userEmail,
            'from'=>'info@ierek.com',
            'cc'=>'test@ierek.com',
            'subject'=>'IEREK confirmation payment',
            'fname'=>$userData->first_name,
            'lastname'=>$userData->last_name,
            'email'=>$userData->email,
            'money'=>$amount,
            'currency'=>$currencyId,
            'event'=>$get_event_name->title_en,
            'start_date'=>$get_event_name->start_date,
            'end_date'=>$get_event_name->end_date,
           // 'barcode'=> $barcode,
            'location'=>$get_event_name->location_en,
            'link'=>'https://www.ierek.com/ticket/'.$encrypted

        );
        Helper::sendmail($data);

        Notifications::create(array(
                      'title' => 'Payment Done',
                      'description' => 'The payment was done successfully, thank you.',
                      'user_id' => Auth::user()->user_id,
                      'color' => 'green',
                      'type' => 'payment-Done',
                      'icon' => 'dollar',
                      'timeout' => 25000,
                      'url' => '/billing',
                      'status' => 'info'
                ));
       
       

                 return redirect('/admin/invoices');
    }
    
    public function autocomplete(Request $request)
    {
	$data = $request->all();
        $term = $data['term'];
	
	$results = array();
	
	$queries = DB::table('users')
		->where('first_name', 'LIKE', '%'.$term.'%')
		->orWhere('last_name', 'LIKE', '%'.$term.'%')
		->take(5)->get();
	
	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->user_id, 'value' => $query->email];
	}
       
return Response::json($results);
}

    public function approveOrdecline(Request $request)
    {
        echo $request['order_id'];
        Orders::where('order_id', $request['order_id'])->update(['status' => $request['status']]);
    }
 
    public function edit($id)
    {
    
         
        $orderData = Orders::where('order_id',$id)->first();
         
        $userData = Users::where('user_id',$orderData['parent_id'])->first();
         $userEmail = $userData['email'];
         $eventId = $orderData['event_id'];
         $amount = $orderData['total'];
         $currency = $orderData['currency'];
         $type = $orderData['order_type'];
         
      
         
          
       
        $currencies = Currencies::all();
        $dt = Carbon::now()->toDateString();
         $events = Events::where('end_date', '>', $dt)->get();
        
         return View('admin/invoices/edit')->with(array(
                'events' => $events,
                'currencies' => $currencies,
                'userEmail' =>$userEmail,
                'eventId' =>$eventId,
                'amount' =>$amount,
                'currencymov' =>$currency,
                'type' =>$type,
                'orderId' => $id
             
             
            ));
        
    }
    
    public function update(Request $request)
    {
             $this->validate($request, [
        'event_id' => 'required',
        'amount' => 'required|integer',
        'currency_id' => 'required',
        'type' => 'required',
     ]);
             
   Orders::where('order_id', $request['order_id'])->update(
           ['event_id' => $request['event_id'],
           'total' => $request['amount'],
           'currency' => $request['currency_id'],
           'order_type' => $request['type']
           ]
           );
   
      Notifications::create(array(
                      'title' => 'Editing Payment Done',
                      'description' => 'The payment was updated successfully, thank you.',
                      'user_id' => Auth::user()->user_id,
                      'color' => 'green',
                      'type' => 'payment-Done',
                      'icon' => 'dollar',
                      'timeout' => 25000,
                      'url' => '/billing',
                      'status' => 'info'
                ));
       
       

                 return redirect('/admin/invoices');
    }
    
       public function searchInvoices()
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
        

        $query = Orders::query()
        ->join ('users as u', 'orders.parent_id', '=' , 'u.user_id')
        ->join ('events as e', 'orders.event_id', '=' , 'e.event_id')
        ->orderBy('order_id', 'DESC')
        ->select('orders.*','u.email','u.first_name','u.last_name','e.title_en','e.end_date');
                
      
        $countOfOrdersWithoutFilter = $query->count();
        
        if(isset($keyword)){
            $query->select("orders.*","users.email","users.first_name","users.last_name","events.title_en","events.end_date")
                    ->join('users',  'orders.parent_id', '=' , 'users.user_id')
                    ->join('events',  'orders.event_id', '=' , 'events.event_id')
                    ->orWhere("users.first_name", "like", "%".$keyword."%")
                    ->orWhere("users.last_name", "like", "%".$keyword."%")
                    ->orWhere("users.email", "like", "%".$keyword."%")
                    ->orWhere("events.title_en", "like", "%".$keyword."%")
                    ->orWhere("orders.currency", "like", "%".$keyword."%")
                    ->orWhere("orders.created_at", "like", "%".$keyword."%")
                    ->orWhere("orders.total", "like", "%".$keyword."%")
                    ->orWhere("orders.payment_id", "like", "%".$keyword."%");
              
        }
        
        if(isset($date)){
             $query->whereDate("orders.created_at", "=", $date);
        }


        $allOrdersCounts = $query->count();
        $orders = $query->paginate($length, ['*'],'page', $pageNumber);
        
        
        $ordersTable = $this->drawTheOrdersDataTable($orders);
    
   
        return response()->json(
                array(
                    'data' => $ordersTable,
                    'recordsTotal' => $countOfOrdersWithoutFilter,
                    'recordsFiltered' => $allOrdersCounts,
                    'draw' => $draw));
                
 }
 
 public function drawTheOrdersDataTable($orders){
        $ordersArray = array();
    
        foreach($orders as $invoice){
            $orderArray = array();
            
            $orderArray['id']= $invoice->order_id.".".$invoice->status.".".$invoice->order_type.".".$invoice->end_date;
            
            if($invoice->payment_id != NULL)
            {
                $orderArray['payment']= $invoice->payment_id;
            }
            else
            {
                $orderArray['payment'] = " ";
            }
            $orderArray['name']= $invoice->first_name." ".$invoice->last_name;
            $orderArray['email']= $invoice->email;
            $orderArray['event'] = $invoice->title_en;
            
            
            if ($invoice->order_type == 3)
                {$orderType="Bank";}
           else if($invoice->order_type == 2)
                {$orderType="Online";}                             
           else if($invoice->order_type == 4)
                {$orderType="Office";}
           else if($invoice->order_type == 1)
                {$orderType="credit";}  
           else if($invoice->order_type == 5)
                {$orderType="Ierek bank account";}
           else if($invoice->order_type == 6)
                {$orderType="Dr.mourad bank account";}
           else if($invoice->order_type == 7)
                {$orderType="Cairo office";}
           else if($invoice->order_type == 8)
                {$orderType="Alex office";}
                                           
                                                    
            $orderArray['order_type'] = $orderType;
            $orderArray['amount'] = $invoice->total;
            $orderArray['currency'] = $invoice->currency;
            $orderArray['date'] = date('Y-m-d', strtotime($invoice->created_at));
            $orderArray['status']  = $invoice->status;
            
            $ordersArray[] = $orderArray;
            }
            return $ordersArray;
        }
    
}
