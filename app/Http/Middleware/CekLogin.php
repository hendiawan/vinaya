<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekLogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        if (Auth::user() &&
            Auth::user()->role != 'AA'&& 
            Auth::user()->role != 'SA'&& 
            Auth::user()->role != 'OW') {
          return redirect()->guest('/');
          //  abort(404);
        }  
        return $next($request);
    }

}
