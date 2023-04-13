<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Notifications;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    //
    public function index()
    {
    	$id = auth()->user()->user_id;
    	$notifications = Notifications::where('user_id', $id)
    				->where('deleted',0)
    				->orderBy('created_at','DESC')
    				->limit(15)
    				->get(['notification_id','title','read','created_at']);

    	return response()->json($notifications, 200);

    }

    //
    public function more($last_notification_id)
    {
    	$id = auth()->user()->user_id;
    	$notifications = Notifications::where('user_id', $id)
    				->where('deleted',0)
    				->where('notification_id','<',$last_notification_id)
    				->orderBy('created_at','DESC')
    				->limit(5)
    				->get(['notification_id','title','read','created_at']);

    	return response()->json($notifications, 200);

    }

    //
    public function push_id(Request $request)
    {
        $id = auth()->user()->user_id;

        $update = Users::where('user_id',$id)->update(['push_id' => $request['push_id']]);

        return response()->json(['message' => 'Successfully updated push notification id!.'], 200);
    }

    //
    public function toggle_push($switch)
    {
        $id = auth()->user()->user_id;

        switch ($switch) {
            case 'on':
                $update = Users::where('user_id',$id)->update(['push_off' => NULL]);
                break;
            
            default:
                $update = Users::where('user_id',$id)->update(['push_off' => 1]);
                break;
        }

        return response()->json(['message' => 'Successfully toggled push notifications '.$switch.'!.'], 200);
    }

    //
    public function push()
    {
        $id = auth()->user()->user_id;

        $push = Users::where('user_id',$id)->first(['push_off']);

        return response()->json(['push_status' => $push['push_off']], 200);
    }

    //
    public function read($notification_id)
    {

    	$id = $notification_id;

        $user_id = auth()->user()->user_id;

    	$read = Notifications::where('notification_id', $id)->where('user_id',$user_id)->update(['read' => 1]);

    	return response()->json(['message' => 'Successfully marked notification as read!.'], 200);

    }
}
