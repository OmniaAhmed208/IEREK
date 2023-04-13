<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Users;

use Session;

use Auth;

class SuperAuthenticate
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
        if(Auth::check())
        {
            if(Auth::user()->user_type_id == 4){
                return $next($request);
            }else{
                abort(404);
            }
        }
        return redirect('/#login');

    }
}