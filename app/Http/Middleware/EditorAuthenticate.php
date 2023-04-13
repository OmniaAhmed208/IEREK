<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;
use Closure;

use Auth;
/**
 * Description of EditorAuthenticate
 *
 * @author Samaa
 */
class EditorAuthenticate {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->user_type_id >= 3){
                return $next($request);
            }else{
                abort(404);
            }
        }else{
            return redirect('/#login');
        }

    }
}
