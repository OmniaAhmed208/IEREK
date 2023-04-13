<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    //
    public function index()
    {
    	$id = auth()->user()->user_id;
    	$messages = Messages::where('user_id', $id)
    				->where('deleted',0)
    				->orderBy('created_at','DESC')
    				->limit(15)
    				->get(['message_id','title','read','created_at']);

    	return response()->json($messages, 200);

    }

    //
    public function more($last_message_id)
    {
    	$id = auth()->user()->user_id;
    	$messages = Messages::where('user_id', $id)
    				->where('deleted',0)
    				->where('message_id','<',$last_message_id)
    				->orderBy('created_at','DESC')
    				->limit(5)
    				->get(['message_id','title','read','created_at']);

    	return response()->json($messages, 200);

    }

    //
    public function message($message_id)
    {

    	$id = $message_id;

        $user_id = auth()->user()->user_id;
    	
    	$messages = Messages::where('message_id', $id)->where('user_id',$user_id)->first(['message_id','title','body','created_at']);

    	$read = Messages::where('message_id', $id)->update(['read' => 1]);

    	return response()->json($messages, 200);

    }

    public function delete($message_id){

        $delete = Messages::where('message_id', $message_id)->update(['deleted' => 1 ]);

        return response()->json(['message' => 'Successfully deleted the message!.'], 200);
    }
}