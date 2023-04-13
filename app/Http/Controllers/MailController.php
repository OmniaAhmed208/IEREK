<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Users;
use App\Models\Events;
use App\Models\EventAbstract;
use App\Models\EventFullPaper;
use App\Models\EventImportantDate;
use App\Models\Orders;
use App\Models\MailTemplates;
use App\Models\EventSection;

use App\Models\Contact;

use App\Models\Notifications;

use App\Models\Messages;


use Mail;

use Config;

use Session;
use Auth;

use Response;

class MailController extends Controller
{
    public function test()
    {

        $email1 = 'mahmoud.ali.kassem@gmail.com';
        $email2 = 'info@vacationsofafrica.com';
        $email3 = 'death_master_l0@hotmail.com';
        $emails = [$email1, $email2, $email3];

        Mail::send('mail.test', [], function($message) use ($emails)
        {    
            $message->from('info@ierek-scholar.org', 'IEREK');
            $message->to('study.abroad@ierek.com');
            $message->bcc($emails);
            $message->subject('This is test e-mail');    
        });
        var_dump( Mail:: failures());
        exit;
    }

    //
    public function welcome($user_id)
    {
    	$user = Users::where('user_id' , $user_id)->first();
    	$title = 'Verify Your Account';
        $content = $user['vcode'];
        $name = $user['first_name'];
        $email = $user['email'];

        Mail::send('mail.welcome', ['title' => $title, 'content' => $content, 'name' => $name], function ($message) use ($email)
        {
            $message->from('info@ierek-scholar.org', 'IEREK');

            $message->to($email);

            $message->subject('IEREK ACCOUNT VERIFICATION');

        });

        return;
    }
    //
    public function welcome_sc($user_id,$pw)
    {
        $user = Users::where('user_id' , $user_id)->first();
        $title = "Welcome to IEREK Scientific Committee's";
        $content = $user['vcode'];
        $name = $user['first_name'];
        $email = $user['email'];

        Mail::send('mail.welcome_sc', ['title' => $title, 'content' => $content, 'name' => $name, 'pw' => $pw], function ($message) use ($email)
        {
            $message->from('info@ierek-scholar.org', 'IEREK');

            $message->to($email);

            $message->subject('IEREK SCIENTIFIC COMMITTEE');

        });

        return;
    }
    public function reverify($user_id)
    {
        $user = Users::where('user_id' , $user_id)->first();
        $title = 'Re-Verification';
        $content = md5(rand(10000,99999));
        $name = $user['first_name'];
        $email = $user['email'];

        $ucode = Users::where('user_id', $user_id)->update(array(
            'vcode' => $content 
        ));

        Mail::send('mail.reverify', ['title' => $title, 'content' => $content, 'name' => $name], function ($message) use ($email)
        {
            $message->from('info@ierek-scholar.org', 'IEREK');

            $message->to($email);

            $message->subject('IEREK ACCOUNT RE-VERIFICATION');

        });
        Session::flash('status','A verification code has been sent to your email.');
        return redirect('/');
    }

    public function compose(Request $request)
    {
        $data = $request->all();
        $title = $data['subject'];
        $content = $data['message'];
        $me = Users::where('user_id',Auth::user()->user_id)->first();
        $from = $me['email'];
        $myname = $me['first_name'].' '.$me['last_name'];
        $to = str_replace(' ', '', $data['to']);
        $emails = explode(',', $to);
        $head = "<hr><small>From: ".$myname." [".$from."] ".date("j F, Y h:i:s")."</small><hr>";
        foreach($emails as $email){
        $user = Users::where('email',$email)->first();
        $name = $user['first_name'].' '.$user['last_name'];
            
            $messagex = Messages::create(array(
                'title' => $title,
                'body' => $head.' '.$content,
                'sender_id' => Auth::user()->user_id,
                'user_id' => $user['user_id'],
                'piority' => 1
            ));

            if($data['msg_only'] != 1){
                $send = Mail::send('mail.compose', 
                    ['title' => $title, 'content' => $content, 'name' => $name, 'email' => $email, 'from' => $from, 'myname' => $myname], 
                    function ($message) use ($email, $myname, $name, $from, $title)
                {
                    $message->from($from, $myname);

                    $message->to($email, $name);

                    $message->subject($title);
                });
            }
        }

        return Response(array(
            'sent' => true,
            'result' => 'Success'
        ));
    }

    public function contact(Request $request)
    {
        $data = $request->all();
        $title = $data['subject'];
        $name = $data['name'];
        $content = $data['message'];
        $email = $data['email'];

        Mail::send('mail.contact', ['title' => $title, 'content' => $content, 'name' => $name, 'email' => $email], function ($message) use ($email, $name)
        {
            $message->from($email, $name);

            $message->to('info@ierek-scholar.org');

            $message->subject('IEREK CONTACT US MESSAGE');
        });
        Mail::send('mail.contact_guest', ['title' => 'We recieved your message', 'name' => $name], function ($message) use ($email, $name)
        {
            $message->from('no-replay@ierek.com', 'IEREK SUPPORT');

            $message->to($email);

            $message->subject('IEREK CONFIRM CONTACT MESSAGE RECIEVED');
        });

        $contact = Contact::create(array(
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message']
        ));

        $users = Users::where('user_type_id','>=', 2)->get();
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            $notification = Notifications::create(array(
                'title' => 'Contact us message from: '.$data['name'],
                'description' => 'Subject: '.$data['subject'].'<br>From: '.$data['name'].' ('.$data['email'].')<br>Message:<br>'.$data['message'],
                'user_id' => $users[$x]['user_id'],
                'color' => '#DC6BAD',
                'type' => 'contact',
                'icon' => 'phone',
                'timeout' => 5000,
                'url' => '/admin/messages',
                'status' => 'info'
            ));

            $id = $notification->id;

            $message = Messages::create(array(
                'title' => 'Contact us message from: '.$data['name'],
                'body' => 'Subject: '.$data['subject'].'<br>From: '.$data['name'].' ('.$data['email'].')<br>Message:<br>'.$data['message'],
                'user_id' => $users[$x]['user_id'],
                'piority' => 1
            ));

            $idx = $message->id;

            $updateUrl = Notifications::where('notification_id', $id)->update(array(
                'url' => '/admin/messages/'.$idx
            ));
        }

        return Response(array('sent' => true));
    }

    public function send(Request $request)
    {
        $data = $request->all();
        //Prepare Data Models

            $userid = $data['user_id'];
        
        @$user = Users::where('user_id',$userid)->first();
        @$event = Events::where('event_id',$data['event'])->first();
        @$abstract = EventAbstract::where('abstract_id',$data['abstract'])->first();
        @$sections = EventSection::where('event_id',$data['event'])->where('position',9)->first();
        @$paper = EventFullPaper::where('paper_id',$data['paper'])->first();
        @$payment_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',7)->first();
        @$payment_dl = date('Y-m-d', strtotime($payment_dl['to_date']));
        @$abstract_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',2)->first();
        @$abstract_dl = date('Y-m-d', strtotime($abstract_dl['to_date']));
        @$paper_dl = EventImportantDate::where('event_id',$data['event'])->where('event_date_type_id',4)->first();
        @$paper_dl = date('Y-m-d', strtotime($paper_dl['to_date']));
        @$template = MailTemplates::where('mail_id',$data['template'])->first();
        @$order = Orders::where('order_id', $data['order'])->first();
        @$inactive = $template['inactive'];
        @$subject = $template['title'];
        @$cc = $template['cc_mails'];
        @$bcc = $template['bcc_mails'];
        @$bcc2 = @$event->email;
        @$contents = $template['message'];
        @$from = $event['email'];
        if($from == null){$from = 'info@ierek-scholar.org';}
        @$to = $user['email'];

        //Replace Template_Variables
        $url = url('/');
        @$contents = str_replace('%first_name%', $user['first_name'], $contents);
        @$contents = str_replace('%last_name%', $user['last_name'], $contents);
        @$contents = str_replace('%email%', $user['email'], $contents);
        @$contents = str_replace('%phone%', $user['phone'], $contents);
        @$contents = str_replace('%creation_date%', date('Y-m-d H:i:s'), $contents);
        @$contents = str_replace('%abstract_title%', $abstract['title'], $contents);
        @$contents = str_replace('%abstract_conference%', $event['title_en'], $contents);
        // Payment
        @$total_currency = $order['total'].' '.$order['currency'];
        @$contents = str_replace('%payment_total%', $total_currency, $contents);
        @$contents = str_replace('%payment_id%', $order['payment_id'], $contents);
        //
        @$contents = str_replace('%paper_title%', $paper['title'], $contents);
        @$contents = str_replace('%paper_conference%', $event['title_en'], $contents);
        @$contents = str_replace('%event_title%', $event['title_en'], $contents);
        @$contents = str_replace('%payment_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#258d1d;padding:8px 8px;border-radius:2px;" href="'.$url.'/payment/'.$event['slug'].'">Pay Now</a>', $contents);
        @$contents = str_replace('%submit_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#0c3852;padding:8px 8px;border-radius:2px;" href="'.$url.'/abstract/'.$event['slug'].'">Submit Your Abstract</a>', $contents);
        @$contents = str_replace('%event_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#aa822c;padding:8px 8px;border-radius:2px;" href="'.$url.'/events/'.$event['slug'].'">View Event</a>', $contents);
        @$contents = str_replace('%event_start%', $event['start_date'], $contents);
        @$contents = str_replace('%event_end%', $event['start_date'], $contents);
        @$contents = str_replace('%payment_deadline%', $payment_dl, $contents);
        @$contents = str_replace('%abstract_deadline%', $abstract_dl, $contents);
        @$contents = str_replace('%paper_deadline%', $paper_dl, $contents);
        @$contents = str_replace('%conferences_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#aa822c;padding:8px 8px;border-radius:2px;" href="'.$url.'/conferences">Conferences</a>', $contents);
        @$contents = str_replace('%workshops_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#aa822c;padding:8px 8px;border-radius:2px;" href="'.$url.'/workshops">Workshops</a>', $contents);
        @$contents = str_replace('%study_abroad_url%', '<a style="color:#fff;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#aa822c;padding:8px 8px;border-radius:2px;" href="'.$url.'/study_abroad">Study Abroad</a>', $contents);
        @$contents = str_replace('%post_graduate_url%', '<a href="'.$url.'/study_abroad_categories#Postgraduate-Studies">Postgraduate</a>', $contents);
        @$contents = str_replace('%post_graduate_application%','<a href="'.$url.'/study_abroad/application_view/'.$data['event'].'/'.$event->category_id.'/'.$event->sub_category_id.'">Application Form</a>',$contents);
        @$contents = str_replace('%event_application%', $sections['description_en'], $contents); 
        @$contents = str_replace('%hr%', '<hr>', $contents);
        @$contents = str_replace('%br%', '<br>', $contents);
        @$contents = str_replace('%center%', '<center>', $contents); @$contents = str_replace('%/center%', '</center>', $contents);
        @$contents = str_replace('%h1%', '<h1 style="margin:4px 0px;color:#0c3852">', $contents); @$contents = str_replace('%/h1%', '</h1>', $contents);
        @$contents = str_replace('%h2%', '<h2 style="margin:3px 0px;color:#9e2021">', $contents); @$contents = str_replace('%/h2%', '</h2>', $contents);
        @$contents = str_replace('%h3%', '<h3 style="margin:2px 0px;color:#21516d">', $contents); @$contents = str_replace('%/h3%', '</h3>', $contents);
        @$contents = str_replace('%h4%', '<h4 style="margin:1px 0px;">', $contents); @$contents = str_replace('%/h4%', '</h4>', $contents);
        @$contents = str_replace('%h5%', '<h5 style="margin:1px 0px;">', $contents); @$contents = str_replace('%/h5%', '</h5>', $contents);
        @$contents = str_replace('%h6%', '<h6 style="margin:0px 0px;">', $contents); @$contents = str_replace('%/h6%', '</h6>', $contents);

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
        @$to = $template['admin_email'];
        @$subject = $template['admin_title'];
        @$contents = $template['admin_message'];
        @$contents = str_replace('%first_name%', $user['first_name'], $contents);
        @$contents = str_replace('%last_name%', $user['last_name'], $contents);
        @$contents = str_replace('%email%', $user['email'], $contents);
        @$contents = str_replace('%phone%', $user['phone'], $contents);
        // Payment
        @$total_currency = $order['total'].' '.$order['currency'];
        @$contents = str_replace('%payment_total%', $total_currency, $contents);
        @$contents = str_replace('%payment_id%', $order['payment_id'], $contents);
        //
        @$contents = str_replace('%creation_date%', date('Y-m-d H:i:s'), $contents);
        @$contents = str_replace('%abstract_title%', $abstract['title'], $contents);
        @$contents = str_replace('%abstract_url%', '<a style="color:#666666;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#f7f7f7;padding:8px 8px;border-radius:2px;" href="'.url('file/'.EventAbstract::abstract_type.'/'.$abstract->abstract_id).'">Download Abstract</a>', $contents);
        @$contents = str_replace('%abstract_conference%', $event['title_en'], $contents);
        @$contents = str_replace('%paper_title%', $paper['title'], $contents);
        @$contents = str_replace('%paper_conference%', $event['title_en'], $contents);
        @$contents = str_replace('%paper_url%', '<a style="color:#666666;display:inline-block;margin-bottom:3px;text-decoration:none;margin-right:3px;background:#f7f7f7;padding:8px 8px;border-radius:2px;" href="'.url('file/'.EventAbstract::fullpaper_type.'/'.$paper->paper_id).'">Download Paper</a>', $contents);
        @$contents = str_replace('%event_title%', $event['title_en'], $contents);
        @$contents = str_replace('%payment_url%', '<a href="'.$url.'/payment/'.$event['slug'].'">Pay Now</a>', $contents);
        @$contents = str_replace('%submit_url%', '<a href="'.$url.'/abstract/'.$event['slug'].'">Submit Abstract</a>', $contents);
        @$contents = str_replace('%event_url%', '<a href="'.$url.'/events/'.$event['slug'].'">'.$event['title_en'].'</a>', $contents);
        @$contents = str_replace('%event_start%', $event['start_date'], $contents);
        @$contents = str_replace('%event_end%', $event['start_date'], $contents);
        @$contents = str_replace('%payment_deadline%', $payment_dl, $contents);
        @$contents = str_replace('%abstract_deadline%', $abstract_dl, $contents);
        @$contents = str_replace('%paper_deadline%', $paper_dl, $contents);
        @$contents = str_replace('%conferences_url%', '<a href="'.$url.'/conferences">Conferences</a>', $contents);
        @$contents = str_replace('%workshops_url%', '<a href="'.$url.'/workshops">Workshops</a>', $contents);
        @$contents = str_replace('%study_abroad_url%', '<a href="'.$url.'/study_abroad">Study Abroad</a>', $contents);
        @$contents = str_replace('%post_graduate_url%', '<a href="'.$url.'/study_abroad_categories#Postgraduate-Studies">Poat Abroad</a>', $contents);
        @$contents = str_replace('%post_graduate_application%','<a href="'.$url.'/study_abroad/application_view/'.$data['event'].'/'.$event->category_id.'/'.$event->sub_category_id.'">Application Form</a>',$contents);
        @$contents = str_replace('%event_application%', $sections['description_en'], $contents);        
        @$contents = str_replace('%hr%', '<hr>', $contents);
        @$contents = str_replace('%br%', '<br>', $contents);
        @$contents = str_replace('%center%', '<center>', $contents); @$contents = str_replace('%/center%', '</center>', $contents);
        @$contents = str_replace('%h1%', '<h1>', $contents); @$contents = str_replace('%/h1%', '</h1>', $contents);
        @$contents = str_replace('%h2%', '<h2>', $contents); @$contents = str_replace('%/h2%', '</h2>', $contents);
        @$contents = str_replace('%h3%', '<h3>', $contents); @$contents = str_replace('%/h3%', '</h3>', $contents);
        @$contents = str_replace('%h4%', '<h4>', $contents); @$contents = str_replace('%/h4%', '</h4>', $contents);
        @$contents = str_replace('%h5%', '<h5>', $contents); @$contents = str_replace('%/h5%', '</h5>', $contents);
        @$contents = str_replace('%h6%', '<h6>', $contents); @$contents = str_replace('%/h6%', '</h6>', $contents);
        if(isset($event['email']) && $event['email'] != ''){
            @$bcc = $event['email'];
        }else{
            @$bcc = null;
        }
        if($to != ''){
            Mail::send('mail.template', ['title' => $subject, 'content' => $contents], function ($message) use ($to,$bcc,$subject)
            {
                $message->from('no-replay@ierek.com', 'IEREK - System Messages');

                $message->to($to);

                if($bcc != null){$message->bcc($bcc);}

                $message->subject($subject);

            });
        }
    }
}

