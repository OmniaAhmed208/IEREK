<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Events;
use App\Models\Users;
use App\Models\EventAttendance;
use App\Models\EventTopic;
use App\Models\EventAbstract;
use App\Models\SponsorShip;
use App\Models\Notifications;
use App\Models\MailTemplates;
use Response;
use Auth;
use Storage;
use Session;
use Mail;


class SponsorShipController extends Controller
{
    //
	public function index($id)
	{
		return view('sponsors.sponsorRules')
                ->with('id',$id);
	}

	public function show($id)
	{		
		return view('sponsors.sponsorApplication')
                ->with('event_id',$id);
	}
        
        public function store(Request $request)
        {
                $data = $request->all();
        
        $this->validate($request, [
           'sponsor_gendar' => 'required',
           'sponsor_title' => 'required',
           'sponsor_name' => 'required',
           'sponsor_organization' => 'required',
           'sponsor_website' => 'required',
           'sponsor_department' => 'required',
           'sponsor_street' => 'required',
           'sponsor_code' => 'required',
           'sponsor_city' => 'required',
           'sponsor_country' => 'required',
           'sponsor_phone' => 'required',
           'sponsor_fax' => 'required',
           'sponsor_mobile' => 'required',
           'sponsor_email' => 'required|email',
           'sponsor_package' => 'required',
           'sponsor_signature' => 'required',
          
    ]);
         $sponsor = SponsorShip::create($request->all());  
          $eventName = Events::where('event_id',$data['sponsor_event'])->value('title_en'); 
//          echo $eventName
          if($sponsor)
           {
               $from = $data['sponsor_email'];
               $email = "omniamagd1993@gmail.com";
               
          

    
     Mail::send('mail.sponsor_mail',
       ['event' => $eventName,'sponsor_name' => $data['sponsor_name'],'sponsor_title' => $data['sponsor_title'],
        'sponsor_organization' => $data['sponsor_organization'],'sponsor_department'=> $data['sponsor_department'],
        'sponsor_country' => $data['sponsor_country'], 'sponsor_phone' => $data['sponsor_phone'],
        'sponsor_package'=>$data['sponsor_package'],'sponsor_city' => $data['sponsor_city']
       ],function ($message) use ($email,$from)
                {
                    $message->from($from);

                    $message->to($email);

                    $message->subject('IEREK - Request sponsorhship');

                });
                
                
         }
         Session::flash("message", "Your request has been submitted successfully!");
         return redirect('/sponsorship_form/'.$data['sponsor_event']);
        }

  
}
