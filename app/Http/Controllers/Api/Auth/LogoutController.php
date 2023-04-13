<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

class LogoutController extends Controller
{
    //
    public function logout()
    {
    	try{

    		JWTAuth::invalidate(JWTAuth::getToken());
    	
    	} catch (JWTAuth $e) {

    		return response()->json([
    			'error'	=> $e
    		], 500);

    	}

    	return response()->json([
    		'message' => 'Successfully logged out user!.'
    	]);
    }
}