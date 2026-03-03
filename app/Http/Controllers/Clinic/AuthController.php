<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\ClinicStaff;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private array $validUsers = [
        'admin@clinic.com'   => ['name' => 'Dr. Admin',        'role' => 'admin',  'otp' => '123456'],
        'doctor@clinic.com'  => ['name' => 'Dr. Ramesh Gupta', 'role' => 'doctor', 'otp' => '234567'],
        'doctor2@clinic.com' => ['name' => 'Dr. Priya Shah',   'role' => 'doctor', 'otp' => '345678'],
        'nurse@clinic.com'   => ['name' => 'Nurse Sunita',     'role' => 'nurse',  'otp' => '456789'],
        'nurse2@clinic.com'  => ['name' => 'Nurse Kavita',     'role' => 'nurse',  'otp' => '567890'],
    ];

    public function showLogin()
    {
        if (session('clinic_logged_in')) {
            return redirect()->route('dashboard');
        }
        return view('clinic.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        if (!isset($this->validUsers[$email])) {
            return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
        }

        $user = $this->validUsers[$email];
        session(['otp_email' => $email, 'otp_code' => $user['otp'], 'otp_sent' => true]);

        return back()->with('otp_sent', true)->with('demo_otp', $user['otp'])->withInput();
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        if (session('otp_email') !== $request->email) {
            return back()->withErrors(['otp' => 'Session expired. Request new OTP.'])->withInput();
        }

        if (session('otp_code') !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Try again.'])->withInput();
        }

        $user = $this->validUsers[$request->email];

        session([
            'clinic_logged_in' => true,
            'clinic_user'      => $user['name'],
            'clinic_email'     => $request->email,
            'clinic_role'      => $user['role'],
        ]);

        session()->forget(['otp_email', 'otp_code', 'otp_sent']);

        return redirect()->route('dashboard')->with('success', 'Welcome, ' . $user['name'] . '!');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}