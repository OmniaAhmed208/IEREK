<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Payment;

/**
 * Description of Twocheckout_Message
 *
 * @author ierek
 */
class Twocheckout_Message
{
    public static function message($code, $message)
    {
        $response = array();
        $response['response_code'] = $code;
        $response['response_message'] = $message;

        return json_encode($response);
    }
}
