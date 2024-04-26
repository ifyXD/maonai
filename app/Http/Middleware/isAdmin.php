<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->role === 'user') {
            return redirect()->route('user.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
