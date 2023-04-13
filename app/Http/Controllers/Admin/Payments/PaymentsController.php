<?php

namespace App\Http\Controllers\Admin\Payments;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;
use App\Models\Events;
use App\Models\Orders;
use App\Models\OrderLines;
use App\Models\Notifications;
use App\Models\EventAttendance;
use App\Models\EventFullPaper;
use Session;

class PaymentsController extends Controller
{
    //
    public function home()
    {
    	$events = Events::all();
    	$orders = Orders::where('status','Pending')->orderBy('created_at','DESC')->paginate(10);
    	foreach($orders as $order){
    		$orderLines = OrderLines::where('order_id', $order['order_id'])->get();
    		$count = 0;
    		$curr = null;
        	if($order['total'] == 0 OR $order['total'] == null){
            	foreach($orderLines as $oLine){
        			$count = $count + $oLine['amount'];
        			$curr = $oLine['currency'];
        		}
                $order['total'] = $count;
            }
    		if($order['currency'] == null){
                $order['currency'] = $curr;
            }
    	}

    	return View('admin.payments.home')->with(array(
    		'events' => $events,
    		'orders' => $orders
    	));
    }

    public function approve($id){
        $approve = Orders::where('order_id',$id)->update(
            [
            'status' => 'APPROVED'
            ]
        );
        $app = Orders::where('order_id',$id)->first();
        $idx = $app['parent_id'];
        $notification = Notifications::create(array(
            'title' => 'Payment Approved',
            'description' => 'Your payment with ID #'.$app['payment_id'].' was approved, thank you.',
            'user_id' => $idx,
            'color' => 'green',
            'type' => 'payment-approved',
            'icon' => 'dollar',
            'timeout' => 25000,
            'url' => '/billing',
            'status' => 'info'
        ));
        // $mail = curl_init('https://www.ierek.com/mail_send?event='.$app['event_id'].'&abstract=&paper=&template=5&user_id='.$idx);
        //         curl_exec($mail);

        Session::flash('status','Payment was approved');
        return redirect('/admin/payments');
    }

    public function decline($id){
        $approve = Orders::where('order_id',$id)->update(
            [
            'status' => 'DECLINED'
            ]
        );
        $app = Orders::where('order_id',$id)->first();
        $idx = $app['parent_id'];
        $notification = Notifications::create(array(
            'title' => 'Payment Declined',
            'description' => 'We are sorry, your payment with ID #'.$app['payment_id'].' was declined! please contact us for more information.',
            'user_id' => $idx,
            'color' => 'red',
            'type' => 'payment-declined',
            'icon' => 'dollar',
            'timeout' => 25000,
            'url' => '/billing',
            'status' => 'info'
        ));

        $orderLines = OrderLines::where('order_id',$id)->get();

        foreach($orderLines as $o) {

            if($o['paper_id'] != null){
                $uPayP = EventFullPaper::where('paper_id',$o['paper_id'])->update([
                    'paid' => 0
                ]);
            } else {
                $uPayAtt = EventAttendance::where('event_attendance_id',$app['event_attendance_id'])->update([
                    'payment' => 0
                ]);
            }
        }

        Session::flash('status','Payment was declined');
        return redirect('/admin/payments');
    }
}

