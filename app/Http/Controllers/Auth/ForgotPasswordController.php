<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Show forgot password form.
     */
    public function showForm()
    {
        return view('pages.forgot-password');
    }

    /**
     * Send reset code (simulated — shows code on screen).
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client) {
            return back()->with('error', 'Email tidak ditemukan dalam sistem kami.')->withInput();
        }

        // Generate random 6-digit code
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session (simulated)
        session([
            'reset_code' => $code,
            'reset_email' => $request->email,
            'reset_expires' => now()->addMinutes(15),
        ]);

        return redirect()->route('password.reset.form')->with('reset_code_sent', $code);
    }

    /**
     * Show the reset form (enter code + new password).
     */
    public function showResetForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.forgot');
        }

        return view('pages.reset-password');
    }

    /**
     * Process the password reset.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify code
        if ($request->code !== session('reset_code')) {
            return back()->with('error', 'Kode verifikasi salah.')->withInput();
        }

        // Check expiry
        if (now()->isAfter(session('reset_expires'))) {
            session()->forget(['reset_code', 'reset_email', 'reset_expires']);
            return redirect()->route('password.forgot')->with('error', 'Kode sudah expired. Silakan minta kode baru.');
        }

        // Update password
        $client = Client::where('email', session('reset_email'))->first();

        if (!$client) {
            return redirect()->route('password.forgot')->with('error', 'Email tidak ditemukan.');
        }

        $client->update([
            'password_hash' => password_hash($request->password, PASSWORD_DEFAULT),
        ]);

        // Clear reset session
        session()->forget(['reset_code', 'reset_email', 'reset_expires']);

        return redirect()->route('home')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
