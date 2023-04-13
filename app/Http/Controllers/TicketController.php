<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Crypt;




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

use Helper;
use Carbon\Carbon;

use Auth;

use Response;

class TicketController extends Controller
{

    public function index($id)
    {

        $decrypted = Crypt::decrypt($id);


        $orderData = Orders::where('order_id',$decrypted)->first();

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
            $start_date = $eventAtt['start_date'];
            $end_date = $eventAtt['end_date'];
            $location = $eventAtt['location_en'];
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

        $code = 'https://www.ierek.com/admin/invoices/show/'. $orderData['order_id']; 

        return view('ticket')->with(array(
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
            'start_date'=> $start_date,
            'end_date'=>$end_date,
            'location'=>$location,

            'barcode' => $code
        ));








    }


}
