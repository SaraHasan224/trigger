<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
{
	public $user_types = [1, 2];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->status == 1) {
            if(in_array(auth()->user()->user_type, $this->user_types)) {
                return $next($request);
            } else {
	            return redirect()->route("home");
            }
        } else {
            $request->session()->flush();
            return redirect()->route("home");
        }
    }
}
