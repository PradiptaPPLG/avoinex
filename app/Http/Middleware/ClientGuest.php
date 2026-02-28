<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (session('client_id')) {
            return redirect('/')->with('info', 'You are already logged in.');
        }
        
        return $next($request);
    }
}