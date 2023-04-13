<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Response;

use App\Models\Newsletter;

class NewsletterController extends Controller
{
    //Subscribe
    public function subscribe(Request $request)
    {
    	$data = $request->all();
    	$email = $data['email'];
    	$err = null;
    	$success = false;
    	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		  $err = "$email is not a valid email address";
		}
		if($err == null){
	    	$check = Newsletter::where('email',$email)->first();
	    	if($check != null){
	    		$err = 'Already Subscribed';
	    	}else{
	    		$subscribe = Newsletter::create(['email' => $email,'name'=> $data['name']]);
	    		$success = true;
	    	}
	    }
	    
    	return Response::json(array('errors' => $err, 'success' => $success));
    }
}
