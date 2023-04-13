<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Payment;
use Twocheckout;
use App\Payment\Twocheckout_Message;
use App\Payment\Twocheckout_Util;

/**
 * Description of Twocheckout_Return
 *
 * @author ierek
 */
class Twocheckout_Return extends Twocheckout
{

    public static function check($params=array(), $secretWord)
    {
        $hashSecretWord = $secretWord;
        $hashSid = $params['sid'];
        $hashTotal = $params['total'];
        $hashOrder = $params['order_number'];
        $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));
        if ($StringToHash != $params['key']) {
            $result = Twocheckout_Message::message('Fail', 'Hash Mismatch');
        } else {
            $result = Twocheckout_Message::message('Success', 'Hash Matched');
        }
        return Twocheckout_Util::returnResponse($result);
    }

}
