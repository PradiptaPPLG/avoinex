<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('client_id')) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        return $next($request);
    }
}