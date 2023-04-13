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

class SendTicketfrombutton extends Controller
{


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */


    public function index($id)
    {

        $data = Orders::where('order_id',$id)->first();

        $orderData = Orders::where('order_id',$id)->first();

        $userData = Users::where('user_id',$orderData['parent_id'])->first();


if($data->status == 'Approved')
{
    $encrypted = Crypt::encrypt($id);

    $data  = array('blade-path' => 'mail.payment-mail',
        'to'=>$userData->email,
        'from'=>'info@ierek.com',
        'cc'=>'test@ierek.com',
        'subject'=>'IEREK confirmation payment',

        'link'=>'https://www.ierek.com/ticket/'.$encrypted

    );
    Helper::sendmail($data);
    return redirect('/admin/invoices');

}
else{

    return  ' please  Approved payment before send ticket ';
}







    }




}
