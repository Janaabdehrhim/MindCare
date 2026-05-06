<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPatient
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Please login as a patient.']);
        }

        return $next($request);
    }
}
