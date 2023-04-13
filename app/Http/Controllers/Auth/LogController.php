<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Response;
use Hash;
use Session;
use Auth;
use App\User;

class LogController extends Controller
{
    //this controller uses model Users to check for login request
    //details to use email submitted from user to bring the hashed
    //password from the database to compare it againest user submitted
    //password which also included in the request data.

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function login(Request $request)
    {
    	// validation data submitted by user at login window(form)
    	$validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required|max:60',
        ]);

    	// handle the request
		if ($validator->fails())
		{

		    return response('Please enter a valid email and password.');

		}
		else
		{

			// check if email is exist and bring password for comparement
	    	$data = $request->all();
	    	$user = Users::where('email', $data['email'])->orwhere('user_login', $data['email'])->first();

	    	// check user password against server hash;
	    	if($user) {

		    	$serverPassword =  $user->password;

		    	if(Hash::check($data['password'], $serverPassword)){

					$member = User::find($user->user_id);
					 //ore use your own way to get the user
					if(isset($request->remember)){
						Auth::login($member, true);
					}else{
						Auth::login($member);
					}
		    		// success response
		    		if($request->ajax()){
		    			return response($user->user_type_id);
		    		}else{
		    			return redirect('/');
		    		}
		    	}
		    	else
		    	{
		    		// worng password response
		            return response('Worng email or password.');

		    	}
	    	}
	    	else
	    	{

	    		// validation error response
	    		return response('This email is not registerd, please register to login.');

	    	}
    	}
    }
}
