<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Mail;

class Helper
{
    public static function sendmail($data)
    {

//dd($data);


        Mail::send($data['blade-path'], $data, function ($message) use ($data)
        {

            $message->from($data['from']);

            $message->to($data['to']);

            $message->subject($data['subject']);





        });



//return view($data['blade-path']);



    }




}