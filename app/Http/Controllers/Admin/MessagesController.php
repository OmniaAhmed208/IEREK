<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Users;

use App\Models\Events;

use App\Models\Messages;

use App\Models\Notifications;

use Session;

use Mail;

use Auth;

use Response;

class MessagesController extends Controller
{

    public function show()
    {
        $messages = Messages::where('user_id',Auth::user()->user_id)->where('deleted',0)->orderBy('created_at','DESC')->get();
        return view('admin.messages')->with(array(
            'messages' => $messages
        ));
    }

    public function read($id)
    {
        $messages = Messages::where('user_id',Auth::user()->user_id)->where('deleted',0)->orderBy('created_at','DESC')->get();
        $msg = Messages::where('user_id',Auth::user()->user_id)->where('message_id',$id)->first();
        $id= $msg['message_id'];
        $read = Messages::where('message_id',$id)->update(array(
            'read' => 1
        ));
        $title = "'".urlencode($msg['title'])."'";
        $sender = "'".urlencode($msg->sender['email'])."'";
        $body = "'".urlencode($msg['body'])."'";
        $title = '<h3>'.$msg['title'].'<br><small style="font-weight: 300!important;color:#777;"">From: '.$msg->sender['first_name'].' '.$msg->sender['last_name'].' ('.$msg->sender['email'].')</small><span class="btn btn-success pull-right" onclick="composeTo('.$sender.','.$title.','.$body.')""><i class="fa fa-reply"></i> Reply</span></h3>';
        return view('admin.messages')->with(array(
            'msg' => $msg,
            'title' => $title,
            'messages' => $messages
        ));
    }

    public function showN()
    {
        $notifications = Notifications::where('user_id',Auth::user()->user_id)->where('deleted',0)->orderBy('created_at','DESC')->get();
        foreach($notifications as $n){
            $show = Notifications::where('notification_id',$n['notification_id'])->update(array(
                'show' => 1 
            ));   
        }
        return view('admin.notifications')->with(array(
            'notifications' => $notifications
        ));

    }


    public function body($id)
    {
        $message = Messages::where('message_id',$id)->where('user_id',Auth::user()->user_id)->first();
        $read = Messages::where('message_id',$id)->where('user_id',Auth::user()->user_id)->update(array(
            'read' => 1 
        ));
        $title = "'".urlencode($message['title'])."'";
        $sender = "'".urlencode($message->sender['email'])."'";
        $body = "'".urlencode($message['body'])."'";
        return Response(json_encode(array(
            'success' => true,
            'result' => '<h3>'.$message['title'].'<br><small style="font-weight: 300!important;color:#777;"">From: '.$message->sender['first_name'].' '.$message->sender['last_name'].' ('.$message->sender['email'].')</small><span class="btn btn-success pull-right" onclick="composeTo('.$sender.','.$title.','.$body.')""><i class="fa fa-reply"></i> Reply</span></h3><p style="white-space: pre-wrap; padding:0em 1em;font-size:16px">'.$message['body'].'</p>'
        )));
    }

    public function bodyN($id)
    {
        $message = Notifications::where('notification_id',$id)->where('user_id',Auth::user()->user_id)->first();
        $read = Notifications::where('notification_id',$id)->where('user_id',Auth::user()->user_id)->update(array(
            'read' => 1 
        ));

        return Response(json_encode(array(
            'success' => true,
            'result' => $message,
            'id' => $message['notification_id']
        )));
    }
    //
    public function compose($user_id, $event_id)
    {
    	$user = Users::where('user_id',$user_id)->first();
    	$event = Events::where('event_id',$event_id)->first();
    	return view('admin.message')->with(array(
    		'user' => $user,
    		'event' => $event
    	));
    }

    public function send(Request $request)
    {
    	$user = Users::where('user_id' , $request['user_id'])->first();
    	$title = $request['title'];
        $content = $request['body'];
        $email = $user['email'];
        $from = $request['event_email'];

        if($request['email'] == 1){
            Mail::send('mail.attendance', ['title' => $title, 'content' => $content], function ($message) use ($email,$from)
            {
                $message->from($from, 'IEREK');

                $message->to($email);

                $message->subject('IEREK - Knowledge & Research Enrichment');

            });
        }
        if($request['piority'] == 1){
            $piority = 1;
            $timeout = 0;
            $color = 'red';
            $alert = 'danger';
        }else{
            $piority = 0;
            $timeout = 10000;
            $color = '#666';
            $alert = 'info';
        }

        if($request['message'] == 1)
        {
            $message = Messages::create(array(
                'sender_id' => Auth::user()->user_id,
                'user_id' => $request['user_id'],
                'title' => $title,
                'body' => $content,
                'piority' => $piority,
                'timeout' => $timeout

            ));
        }

        if($request['notification'] == 1)
        {
            $notification = Notifications::create(array(
                'user_id' => $request['user_id'],
                'title' => $title,
                'description' => $content,
                'type' => 'conference',
                'icon' => 'info',
                'status' => $alert,
                'color' => $color,
                'timeout' => $timeout,
                'url' => '/messages'

            ));

            $id = $notification->id;

            $updateUrl = Notifications::where('notification_id', $id)->update(array(
                'url' => '/messages#'.$id
            ));
        }

        return Response(json_encode(array('sent' => 'true')));
    }
    public function send_group(Request $request)
    {
        $users = $request['users'];
        $title = $request['title'];
        $content = $request['body'];
        $from = $request['event_email'];
        $cusers = sizeof($users);
        for ($x = 0; $x < $cusers; $x++) {
            $user = Users::where('user_id' , $users[$x])->first();
            $email = $user['email'];
            $user_id = $user['user_id'];
            $contents = str_replace('%first_name%', $user['first_name'], $content);
            if($request['email'] == 1){
                Mail::send('mail.attendance', ['title' => $title, 'content' => $contents], function ($message) use ($email,$from)
                {
                    $message->from($from, 'IEREK');

                    $message->to($email);

                    $message->subject('IEREK - Knowledge & Research Enrichment');

                });
            }
            if($request['piority'] == 1){
                $piority = 1;
                $timeout = 0;
                $color = 'red';
                $alert = 'danger';
            }else{
                $piority = 0;
                $timeout = 10000;
                $color = '#666';
                $alert = 'info';
            }

            if($request['message'] == 1)
            {
                $message = Messages::create(array(
                    'sender_id' => Auth::user()->user_id,
                    'user_id' => $user_id,
                    'title' => $title,
                    'body' => $contents,
                    'piority' => $piority,
                    'timeout' => $timeout

                ));
            }

            if($request['notification'] == 1)
            {
                $notification = Notifications::create(array(
                    'user_id' => $user_id,
                    'title' => $title,
                    'description' => $contents,
                    'type' => 'conference',
                    'icon' => 'info',
                    'status' => $alert,
                    'color' => $color,
                    'timeout' => $timeout,
                    'url' => '/notifications'

                ));
            }


        }
        
        return Response(json_encode(array(
            'sent' => 'true'
        )));
    }
}
