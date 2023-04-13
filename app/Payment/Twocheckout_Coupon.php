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
 * Description of Twocheckout_Coupon
 *
 * @author ierek
 */
class Twocheckout_Coupon extends Twocheckout
{

    public static function create($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/create_coupon';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function retrieve($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        if(array_key_exists("coupon_code",$params)) {
            $urlSuffix = '/api/products/detail_coupon';
        } else {
            $urlSuffix = '/api/products/list_coupons';
        }
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function update($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/update_coupon';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function delete($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/delete_coupon';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

}
