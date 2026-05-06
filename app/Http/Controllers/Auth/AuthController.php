<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Pages
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'regex:/^[A-Za-z\-_\.0-9]+@(gmail|yahoo)\.com$/'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'regex:/^[A-Za-z0-9]+$/'],
            'role'     => ['required', 'in:patient,therapist,admin'],
        ]);

        return match ($request->role) {
            'patient'   => $this->loginPatient($request),
            'therapist' => $this->loginTherapist($request),
            'admin'     => $this->loginAdmin($request),
        };
    }

    private function loginPatient(Request $request)
    {
        if (!Auth::guard('patient')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Can\'t find an account with these credentials.']);
        }

        $request->session()->regenerate();
        return redirect()->route('patient.profile');
    }

    private function loginTherapist(Request $request)
    {
        if (!Auth::guard('therapist')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Can\'t find an account with these credentials.']);
        }

        $request->session()->regenerate();
        return redirect()->route('therapist.profile');
    }

    private function loginAdmin(Request $request)
    {
        $emailMatch    = $request->email === config('admin.email');
        $passwordMatch = Hash::check($request->password, config('admin.password'));

        if (!$emailMatch || !$passwordMatch) {
            return back()->withErrors(['email' => 'Admin credentials are incorrect.']);
        }

        $request->session()->regenerate();
        session(['admin_logged_in' => true]);

        return redirect()->route('admin.dashboard');
    }

    // Register (Patients Only)
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z]+$/'],
            'last_name'  => ['required', 'string', 'max:255', 'regex:/^[A-Za-z]+$/'],
            'email'      => ['required', 'email', 'unique:patients,email', 'regex:/^[A-Za-z\-_\.0-9]+@(gmail|yahoo)\.com$/'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'age'        => ['required', 'integer', 'min:10'],
            'gender'     => ['required', 'in:male,female'],
        ]);

        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'age'        => $request->age,
            'gender'     => $request->gender,
        ]);

        Auth::guard('patient')->login($patient);
        $request->session()->regenerate();

        return redirect()->route('patient.intake');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        Auth::guard('therapist')->logout();
        $request->session()->forget('admin_logged_in');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
