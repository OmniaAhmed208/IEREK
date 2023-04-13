<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;
use Auth;

class RefreshTokenController extends Controller
{
    //
    public function refresh()
    {
    	
        try
        {
            $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            $user = JWTAuth::setToken($refreshed)->toUser();
        }
        catch (JWTException $e)
        {
             return response()->json([
				'error' => 'token_expired'
             ], 500);
        }

        // Login the user instance for global usage
        Auth::login($user, false);

        return response()->json([
        	'token'	=> $refreshed
        ], 200);
    }
}
