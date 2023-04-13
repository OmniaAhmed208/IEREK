<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Titles;
use App\Models\SubCategory;
use App\Models\EventAttendance;
use App\Models\StudyAbroadApplication;
use App\Models\Events;
use App\Models\MailTemplates;
use Session;
use Mail;
use DB;


class Paymentmail extends Controller
{


    public function sendmail(Request $request)
    {
       $data = $request->all();


            $from = $request->app_email;
            $email = "study.abroad@ierek-scholar.org";
            $cc = "info@ierek-scholar.org";
//
//'mail.payment-mail.blade.php'
Mail::send($data['bladefile'] ,
                ['eventName'=> $data['eventName'],'app_undersigned_name' => $data['app_undersigned_name'],
                    'app_date_birth_day' => $data['app_date_birth_day'],'app_city' => $data['app_city'],'app_state' => $data['app_state'],
                    'app_state_of_residence' => $data['app_state_of_residence'], 'app_permanent_address' => $data['app_permanent_address'],
                    'app_email'=>$data['app_email'],'app_signature' => $data['app_signature']
                ],function ($message) use ($cc,$email,$from)
                {
                    $message->from($from);

                    $message->to($email);
                    $message->cc($cc);
                    $message->subject('IEREK - Studyabroad Application');

                });




        Session::flash("message", "Your request has been submitted successfully!");
        return redirect('study_abroad/application_view/'.$data['app_event_id'].'/'.$data['app_category'].'/'.$data['app_sub_category']);

    }
}
