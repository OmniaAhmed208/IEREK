<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Events;
use App\Models\EventAbstract;
use App\Models\EventFullPaper;
use App\Models\EventImportantDate;
use App\Models\MailTemplates;
use Mail;
use Config;
use Session;
use Auth;

class MailController extends Controller
{
    //
    public function send(Request $request)
    {
    	$data = $request->all();
    	//Prepare Data Models
    	@$user = Users::where('user_id',Auth::user()->user_id)->first();
    	@$event = Events::where('event_id',$data['event'])->first();
    	@$abstract = EventAbstract::where('abstract_id',$data['abstract'])->first();
    	@$paper = EventFullPaper::where('paper_id',$data['paper'])->first();
    	@$payment_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',7)->get();
        @$payment_dl = $payment_dl['to_date'];
    	@$abstract_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',2)->get();
        @$abstract_dl = $abstract_dl['to_date'];
    	@$paper_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',4)->get();
    	@$paper_dl = $paper_dl['to_date'];
        @$template = MailTemplates::where('mail_id',$data['template'])->first();
    	@$inactive = $template['inactive'];
    	@$subject = $template['title'];
    	@$cc = $template['cc_mails'];
    	@$bcc = $template['bcc_mails'];
        @$contents = $template['message'];
    	@$from = $event['email'];
    	if($from == null){$from = 'info@ierek-scholar.org';}
    	@$to = Auth::user()->email;

    	//Replace Template_Variables
        $url = url('/');
        @$contents = str_replace('%first_name%', $user['first_name'], $contents);
        @$contents = str_replace('%last_name%', $user['last_name'], $contents);
        @$contents = str_replace('%abstract_title%', $abstract['title'], $contents);
        @$contents = str_replace('%abstract_conference%', $event['title_en'], $contents);
        @$contents = str_replace('%paper_title%', $paper['title'], $contents);
        @$contents = str_replace('%paper_conference%', $event['title_en'], $contents);
        @$contents = str_replace('%event_title%', $event['title_en'], $contents);
        @$contents = str_replace('%event_url%', '<a href="'.$url.'/events/'.$event['slug'].'">Click Here</a>', $contents);
        @$contents = str_replace('%event_start%', $event['start_date'], $contents);
        @$contents = str_replace('%event_end%', $event['start_date'], $contents);
        @$contents = str_replace('%payment_deadline%', $payment_dl, $contents);
        @$contents = str_replace('%abstract_deadline%', $abstract_dl, $contents);
        @$contents = str_replace('%paper_deadline%', $paper_dl, $contents);
    	@$contents = str_replace('%conferences_url%', '<a href="'.$url.'/conferences">Conferences</a>', $contents);
    	@$contents = str_replace('%workshops_url%', '<a href="'.$url.'/workshops">Workshops</a>', $contents);
    	@$contents = str_replace('%study_abroad_url%', '<a href="'.$url.'/study_abroad">Study Abroad</a>', $contents);
    	@$contents = str_replace('%hr%', '<hr>', $contents);
    	@$contents = str_replace('%center%', '<center>', $contents); @$contents = str_replace('%/center%', '</center>', $contents);
    	@$contents = str_replace('%h1%', '<h1>', $contents); @$contents = str_replace('%/h1%', '</h1>', $contents);
    	@$contents = str_replace('%h2%', '<h2>', $contents); @$contents = str_replace('%/h2%', '</h2>', $contents);
    	@$contents = str_replace('%h3%', '<h3>', $contents); @$contents = str_replace('%/h3%', '</h3>', $contents);
    	@$contents = str_replace('%h4%', '<h4>', $contents); @$contents = str_replace('%/h4%', '</h4>', $contents);
    	@$contents = str_replace('%h5%', '<h5>', $contents); @$contents = str_replace('%/h5%', '</h5>', $contents);
    	@$contents = str_replace('%h6%', '<h6>', $contents); @$contents = str_replace('%/h6%', '</h6>', $contents);

    	if($inactive != 1){
            Mail::send('mail.template', ['title' => $subject, 'content' => $contents], function ($message) use ($to,$from,$cc,$bcc,$subject)
            {
                $message->from($from, 'IEREK - Knowledge & Research Enrichment');

                $message->to($to);

                if($cc != null){$message->cc($cc);}

                if($bcc != null){$message->bcc($bcc);}

                $message->subject($subject);

            });
        }
    }
}
