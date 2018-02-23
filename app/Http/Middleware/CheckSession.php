<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        if(!$request->session()->has('check_in')){
            return redirect('/')
                ->withInput($request->except('_token'))
                ->with([
                    'session_expired' => true
                ]);
        }
        return $next($request);
    }
}
