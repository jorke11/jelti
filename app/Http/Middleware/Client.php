<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Closure;
use Auth;

class Client {

    protected $auth;

    public function __constructor(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        if (in_array(Auth::User()->role_id, array(1, 4, 5, 6, 7))) {
            return $next($request);
        }else{
            return $next("/client");
        }
        
    }

}
