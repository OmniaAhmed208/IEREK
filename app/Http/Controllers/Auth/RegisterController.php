<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Users;
use App\Models\Notifications;
use App\Http\Controllers\Controller;
use Response;
use Hash;
use App\User;
use Session;
use Auth;

class RegisterController extends Controller
{
    //
    /*this controller validate the submitted infromation by the user at register form window
    then response with errors or create new user if no errors*/


    public function register(Request $request)
    {

    	// validating submitted data
    	$validator = Validator::make($request->all(), [
            'first_name' => 'required|alpha|min:3|max:255',
            'last_name' => 'required|alpha|min:3|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|min:8|max:60',
            'user_title' => 'required|not_in:0',
            'country' => 'required|not_in:0',
            'age' => 'required',
            'phone'	=> 'required|phone:AUTO',
            'gender' => 'required',
            'slug' => 'required|unique:users|regex:/(^([a-zA-Z_-]+)(\d+)?$)/u'
        ]);

    	// return validation errors if exist
		if ($validator->fails())
		{
		    return Response::json(array(
		        'success' => false,
		        'errs' => $validator->getMessageBag()->toArray()

		    ), 400); // 400 being the HTTP code for an invalid request.
		}
		else
		{
        	// Store the new user data...
                   
            $vcode = md5(rand(10000,99999));
        	$user = Users::create(array(
        		'first_name' => $request['first_name'],
        		'last_name' => $request['last_name'],
        		'email' => $request['email'],
        		'password' => addslashes(Hash::make($request['password'])),
        		'user_title_id' => $request['user_title'],
        		'age' => $request['age'],
                'gender' => $request['gender'],
        		'country_id' => $request['country'],
        		'phone' => $request['phone'],
                'vcode' => $vcode,
                'verified' => 0,
        		'user_type_id' => 0,
        	));

            $id = $user->id;
        	// return success message
			// create user session
            $users = Users::where('user_type_id','>=', 2)->get();
            $cusers = sizeof($users);
            for ($x = 0; $x < $cusers; $x++) {
                $notification = Notifications::create(array(
                    'title' => 'New user registered: '.$request['first_name'].' '.$request['last_name'],
                    'description' => 'Email: '.$request['email'].' Phone: '.$request['phone'].' Date: '.date('Y-m-d h:i:s'),
                    'user_id' => $users[$x]['user_id'],
                    'color' => 'yellow',
                    'type' => 'users-registration',
                    'icon' => 'users',
                    'timeout' => 5000,
                    'url' => '/admin/all-users/profile/'.$id,
                    'status' => 'info'
                ));
            }

			$member = User::find($id);
            //ore use your own way to get the user
            Auth::login($member);
            Session::flash('status','Welcome to IEREK '.$user->first_name.'!');
            $mail1 = curl_init(url('mail/verify/'.$id));
            $mail = curl_init(url('mail_send?template=1&user_id='.$member['user_id']));
        	return Response::json(array(
                'success' => true,
                'mail'  => curl_exec($mail),
                'mail1' => curl_exec($mail1),
                'name' =>  $request['first_name'].' '. $request['last_name'],
                'email' =>  $request['email']
            ), 200);
		}
    }
}
