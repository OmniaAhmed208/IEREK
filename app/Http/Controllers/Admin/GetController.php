<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Notifications;
use App\Models\Messages;
use App\Models\Users;
use Auth;

use Session;

class GetController extends Controller
{
    //
    function element($element, Request $request)
    {
    	switch ($element) {
    		case 'notifications':
    			$result = Notifications::where('read', 0)->where('user_id',Auth::user()->user_id)->limit(10)->orderBy('created_at','DESC')->get();
    			
    			foreach($result as $res)
    			{
    				$show = Notifications::where('notification_id',$res['notification_id'])->update(array(
    					'show' => 1
    				));
    			}
    			break;

            case 'logs':
                $d = $request->all();
                $from = $d['from'];
                $to = $d['to'];
                $cat = $d['category'];
                $date = array($from, $to);
                if($cat == 'all'){
                    $result = Notifications::where('user_id',Auth::user()->user_id)->whereBetween('created_at', $date)->get();
                }else{
                    $result = Notifications::where('user_id',Auth::user()->user_id)->where('type', $cat)->whereBetween('created_at', $date)->get();
                }
                break;
            case 'messages':
                $result = Messages::where('read', 0)->where('deleted', 0)->where('user_id',Auth::user()->user_id)->limit(10)->orderBy('created_at','DESC')->get();
                
                foreach($result as $res)
                {
                    $show = Messages::where('message_id',$res['message_id'])->update(array(
                        'show' => 1
                    ));
                }
                break;
            case 'menu':
                $user = Users::where('user_id',Auth::user()->user_id)->first();
                $result = $user['menu_toggle'];
                break;
            case 'menu-toggle':
                $toggle = Users::where('user_id',Auth::user()->user_id)->update(array(
                    'menu_toggle' => 1
                ));
                $result = 1;
                break;
            case 'menu-toggle-off':
                $toggle = Users::where('user_id',Auth::user()->user_id)->update(array(
                    'menu_toggle' => 0
                ));
                $result = 0;
                break;
    		default:
			    
			    break;
    	}
        if(count($result) > 0){$msg = true;}else{$msg = false;}
    	return Response(array('success' => $msg, 'result' => $result));
    }
}
