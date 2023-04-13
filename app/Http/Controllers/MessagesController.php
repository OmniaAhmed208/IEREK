<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

use App\Models\Messages;

use App\Models\Notifications;
use Auth;

class MessagesController extends Controller
{
    //
    public function show()
    {
    	$messages = Messages::where('user_id',Auth::user()->user_id)->where('deleted',0)->orderBy('created_at','DESC')->get();
    	return view('messages')->with(array(
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
        return view('notifications')->with(array(
            'notifications' => $notifications
        ));

    }

    public function body($id)
    {
    	$message = Messages::where('message_id',$id)->where('user_id',Auth::user()->user_id)->first();
    	$read = Messages::where('message_id',$id)->where('user_id',Auth::user()->user_id)->update(array(
    		'read' => 1	
    	));

    	return Response(json_encode(array(
            'success' => true,
            'result' => '<h3>'.$message['title'].'</h3><p style="white-space: pre-wrap; padding:0em 1em">'.$message['body'].'</p>'
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

    public function delete($id)
    {
    	$delete = Messages::where('message_id',$id)->where('user_id',Auth::user()->user_id)->update(array(
    		'deleted' => 1
    	));
    	return Response(json_encode(array(
            'success' => true
    	)));
    }

    public function deleteN($id)
    {
        $delete = Notifications::where('notification_id',$id)->where('user_id',Auth::user()->user_id)->update(array(
            'deleted' => 1
        ));
        return Response(json_encode(array(
            'success' => true
        )));
    }
}
