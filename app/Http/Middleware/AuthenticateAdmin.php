<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}

