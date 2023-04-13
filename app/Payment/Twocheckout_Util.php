<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Payment;

use Twocheckout;


/**
 * Description of Twocheckout_Util
 *
 * @author ierek
 */
class Twocheckout_Util extends Twocheckout
{

    static function returnResponse($contents, $format=null) {
        $formatType = $format == null ? Twocheckout::$format : $format;
        
        switch ($formatType) {
            case "array":
                $response = self::objectToArray($contents);
                self::checkError($response);
                break;
            case "force_json":
                $response = self::objectToJson($contents);
                break;
            default:
                $response = self::objectToArray($contents);
                self::checkError($response);
                $response = json_encode($contents);
                $response = json_decode($response);
        }
        return $response;
    }

    public static function objectToArray($object)
    {
        $object = json_decode($object, true);
        $array=array();
        foreach($object as $member=>$data)
        {
            $array[$member]=$data;
        }
        
        return $array;
    }

    public static function objectToJson($object)
    {
        return json_encode($object);
    }

    public static function getRecurringLineitems($saleDetail) {
        $i = 0;
        $invoiceData = array();

        while (isset($saleDetail['sale']['invoices'][$i])) {
            $invoiceData[$i] = $saleDetail['sale']['invoices'][$i];
            $i++;
        }

        $invoice = max($invoiceData);
        $i = 0;
        $lineitemData = array();

        while (isset($invoice['lineitems'][$i])) {
            if ($invoice['lineitems'][$i]['billing']['recurring_status'] == "active") {
                $lineitemData[] = $invoice['lineitems'][$i]['billing']['lineitem_id'];
            }
            $i++;
        };

        return $lineitemData;

    }

    public static function checkError($contents)
    {
        if (isset($contents['errors'])) {
            throw new Twocheckout_Error($contents['errors'][0]['message']);
        } elseif (isset($contents['exception'])) {
            throw new Twocheckout_Error($contents['exception']['errorMsg'], $contents['exception']['errorCode']);
        }
    }

}
