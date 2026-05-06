<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTherapist
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('therapist')->check()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login as a therapist.']);
        }

        return $next($request);
    }
}
