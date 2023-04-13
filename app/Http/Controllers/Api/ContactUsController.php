<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\MailTemplates;
use App\Models\Contact;
use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Users;
use Mail;

class ContactUsController extends Controller
{
    //
    public function contact_us(Request $request)
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

        return response()->json([
        	'success' => true, 
        	'message'=>'Message sent successfully!'
        ]);
    }
}