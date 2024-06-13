<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->hasSession() && $request->session()->has('last_activity')) {
            $diff = now()->diffInMinutes($request->session()->get('last_activity'));

            if ($diff > 10) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'You have been logged out due to inactivity.');
            }

            $request->session()->put('last_activity', now());
        }

        return $next($request);
    }
}
