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
 * Description of Twocheckout_Product
 *
 * @author ierek
 */
class Twocheckout_Product extends Twocheckout
{

    public static function create($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/create_product';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function retrieve($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        if(array_key_exists("product_id",$params)) {
            $urlSuffix = '/api/products/detail_product';
        } else {
            $urlSuffix = '/api/products/list_products';
        }
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function update($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/update_product';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

    public static function delete($params=array())
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/products/delete_product';
        $result = $request->doCall($urlSuffix, $params);
        return Twocheckout_Util::returnResponse($result);
    }

}