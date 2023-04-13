<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Helper;
use App\Models\Users;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

use Crypt;
class testcontroller extends Controller
{

    public function index()
    {

        $encrypted = Crypt::encrypt('450');
        //$barcode = Users::barcodeGenerator($encrypted);




        $data  = array('blade-path' => 'mail.payment-mail',
            'to'=>'ayousry943@gmail.com',
            'from'=>'info@irek.com',
            'cc'=>'test@irek.com',
            'subject'=>'IEREK confirmation payment',
            'fname'=>'ahmed ',
            'lastname'=>'yousry',
            'email'=>'ayousry943@gmail.com',
            'start_date'=>'10-10-2017',
            'end_date'=>'10-10-2017',
            'money'=>'350',
            'currency'=>'USD',
            'event'=>'event in cairo',

            'location'=>'cairo',
            'link'=>'http://yousry.ierek/index.php/ticket/'.$encrypted

        );




        $decrypted = Crypt::decrypt($encrypted);

        return  Helper::sendmail($data);
    }

}