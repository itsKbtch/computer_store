<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
       // if (Auth::guard($guard)->check()) {
           // return redirect('/');
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.home.index');
                }
                # code...
                break;
            
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/');
                }
                # code...
                break;
        }
        return $next($request);
   }
}
