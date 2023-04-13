<?php
namespace App\Payment;

use Twocheckout;
use App\Payment\Twocheckout_Api_Requester;
use App\Payment\Twocheckout_Util;

/**
 * Description of Twocheckout_Company
 *
 * @author ierek
 */
class Twocheckout_Company extends Twocheckout
{
    public static function retrieve()
    {
        $request = new Twocheckout_Api_Requester();
        $urlSuffix = '/api/acct/detail_company_info';
        $result = $request->doCall($urlSuffix);
        return Twocheckout_Util::returnResponse($result);
    }
}
