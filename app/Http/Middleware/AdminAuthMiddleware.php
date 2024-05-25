<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (Auth::guard('admin')->check()) {
            // If the user is authenticated, allow the request to continue
            return $next($request);
        }

        // If the user is not authenticated, redirect to the login page or display an error message
        return redirect()->route('admin.login')->withErrors([
            'message' => 'You must be logged in to access this page.'
        ]);
    }
}
