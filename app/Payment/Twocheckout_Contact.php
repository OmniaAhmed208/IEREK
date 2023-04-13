<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Payment;


use Twocheckout;
use App\Payment\Twocheckout_Api_Requester;
use App\Payment\Twocheckout_Util;


/**
 * Description of Twocheckout_Contact
 *
 * @author ierek
 */
class Twocheckout_Contact extends Twocheckout
{

    public static function retrieve()
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/acct/detail_contact_info';
        $result = $request->doCall($urlSuffix);
        return Twocheckout_Util::returnResponse($result);
    }
}
