<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Models\Titles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class RegisterController extends Controller
{
    //
	public function index()
	{
		return response()->json([
			'user_titles' => Titles::where('user_title_id','>',0)->get(['user_title_id','title'])
        ], 200);
	}


    public function register(Request $request)
    {

    	// validating submitted data
    	$this->validate($request, [
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|unique:users|email|max:50',
            'password' => 'required|min:8|max:60',
            'user_title_id' => 'required|not_in:0',
            'country_id' => 'required|not_in:0',
            'age' => 'required|date_format:Y-m-d',
            'phone'	=> 'required',
            'gender' => 'required'
        ]);

        // adding validated user data
        $user = new User([
        	'first_name'	=>		$request->input('first_name'),
        	'last_name'		=>		$request->input('last_name'),
        	'email'			=>		$request->input('email'),
        	'password'		=>		addslashes(Hash::make($request->input('password'))),
        	'user_title_id'	=>		$request->input('user_title_id'),
        	'country_id'	=>		$request->input('country_id'),
        	'age'			=>		$request->input('age'),
        	'phone'			=>		$request->input('phone'),
        	'gender'		=>		$request->input('gender')
        ]);

        // saving user into database
        $user->save();

        // authenticate user and generate token
        $credentials = $request->only('email', 'password');
        try {
        	if(!$token = JWTAuth::attempt($credentials)) {
        		return response()->json([
        			"message"	=> "Successfully created user!",
        			"error" => "Faild to authenticate"
        		], 401);
        	}
        } catch (JWTException $e) {
        	return response()->json([
        		"message"	=> "Successfully created user!",
        		"error"	=> "Couldn't authenticate, please try again"
        	], 500);
        }

       	// Login the user instance for global usage
        auth()->login($user, false);
        
        return response()->json([
       		"message"	=> "Successfully created user!",
       		"token"		=> $token
       	], 201);

    }
}
