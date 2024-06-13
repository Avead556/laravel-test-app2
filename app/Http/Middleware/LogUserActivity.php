<?php

namespace App\Http\Middleware;

use App\Models\UserActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'route' => $request->getRequestUri(),
            'payload' => json_encode($request->except(['password', 'password_confirmation'])),
        ]);

        return $next($request);
    }
}
