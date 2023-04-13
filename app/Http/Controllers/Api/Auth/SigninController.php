<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class SigninController extends Controller
{
    //
    public function signin(Request $request) {

    	$this->validate($request, [
            'email' => 'required|email|max:50',
            'password' => 'required|min:8|max:60'
        ]);

    	$credentials = $request->only('email', 'password');
        try {
        	if(!$token = JWTAuth::attempt($credentials)) {
        		return response()->json([
        			"error" => "Wrong email or password"
        		], 401);
        	}
        } catch (JWTException $e) {
        	return response()->json([
        		"error"	=> "Couldn't sign in, please try again"
        	], 500);
        }

       	return response()->json([
       		"message"	=> "Successfully signed in user!",
       		"token"		=> $token
       	], 200);
    }
}
