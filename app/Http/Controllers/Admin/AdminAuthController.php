<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    // Demo credentials with OTP
    private $validUsers = [
        'admin@society.com' => ['name' => 'Admin', 'otp' => '123456'],
        'manager@society.com' => ['name' => 'Manager', 'otp' => '654321'],
        'secretary@society.com' => ['name' => 'Secretary', 'otp' => '111222'],
    ];

    public function showLogin()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        if (!isset($this->validUsers[$email])) {
            return back()->withErrors(['email' => 'No account found with this email address.'])->withInput();
        }

        // Store OTP in session (in real app, send via SMS/Email)
        $otp = $this->validUsers[$email]['otp'];
        session(['otp_email' => $email, 'otp_code' => $otp, 'otp_sent' => true]);

        return back()->with('otp_sent', true)->with('demo_otp', $otp)->withInput();
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $email = $request->email;
        $enteredOtp = $request->otp;

        if (session('otp_email') !== $email) {
            return back()->withErrors(['otp' => 'Session expired. Please request a new OTP.'])->withInput();
        }

        if (session('otp_code') !== $enteredOtp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.'])->withInput();
        }

        $user = $this->validUsers[$email];

        session([
            'admin_logged_in' => true,
            'admin_user' => $user['name'],
            'admin_email' => $email,
        ]);

        session()->forget(['otp_email', 'otp_code', 'otp_sent']);

        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!');
    }

    public function login(Request $request)
    {
        // Legacy fallback
        return redirect()->route('admin.login');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_user', 'admin_email']);
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}