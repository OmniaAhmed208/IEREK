<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Payment;

use Exception;

/**
 * Description of Twocheckout_Error
 *
 * @author ierek
 */
class Twocheckout_Error extends Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return "{$this->message}\n";
        // return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
