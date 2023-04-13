<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class AdminAuthenticate
{
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
            if(Auth::user()->user_type_id >= 2){
                return $next($request);
            }else{
                abort(404);
            }
        }else{
            return redirect('/#login');
        }

    }
}
