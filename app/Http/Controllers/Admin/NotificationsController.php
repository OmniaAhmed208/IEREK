<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Notifications;

use Response;

class NotificationsController extends Controller
{
    //
    public function read($id)
    {
    	$read = Notifications::where('notification_id',$id)->update(array(
    		'read' => 1
    	));

    	return Response::json(array('success' => true));
    }

    public function send_notification(Request $request)
    {
    	function sendMessage(){
		$content = array(
			"en" => 'Test from Laravel'
			);
		$decorate = array(
            "headings_color" => 'ff0e293c',
            "contents_color" => 'ff00263a'
            );
		$fields = array(
			'app_id' => "5bf31562-048f-4a35-a6f9-0693b739d77d",
			'included_segments' => array('All'),
            'data' => array("test" => "true"),
            // 'big_picture' => @$request['image'],
            'big_picture' => "http://68.media.tumblr.com/7e73ba5d0fffde9fabb7778d59e3b50f/tumblr_inline_mmad5zOwOp1qz4rgp.png",
            'priority' => 10,
			'contents' => $content
            
		);
		
		$fields = json_encode($fields);
	    print("\nJSON sent:\n");
	    print($fields);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
													   'Authorization: Basic ZjNmMDZlOTktNjQ3ZS00NTc0LWExZDktNTU2YWUxNDZiNTAx'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			$response = curl_exec($ch);
			curl_close($ch);
			
			return $response;
		}
		
		$response = sendMessage();
		$return["allresponses"] = $response;
		$return = json_encode( $return);
		
		print("\n\nJSON received:\n");
		print($return);
		print("\n");
    }
}
