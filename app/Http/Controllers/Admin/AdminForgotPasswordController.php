<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminResetPasswordMail;

class AdminForgotPasswordController extends Controller
{
    /**
     * Show forgot password form (email input).
     */
    public function showForm()
    {
        return view('admin.forgot-password');
    }

    /**
     * Verify email matches recovery email, then generate OTP.
     */
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Get recovery email from site settings
        $recoveryEmail = SiteSetting::getValue('recovery_email', '');

        if (empty($recoveryEmail)) {
            return back()->with('error', 'Email pemulihan belum di-setting. Hubungi developer/superadmin.')->withInput();
        }

        // Check if the entered email matches recovery email
        if (strtolower(trim($request->email)) !== strtolower(trim($recoveryEmail))) {
            return back()->with('error', 'Email tidak cocok dengan email pemulihan yang terdaftar.')->withInput();
        }

        // Verify an admin account exists
        $admin = Admin::first();
        if (!$admin) {
            return back()->with('error', 'Akun admin tidak ditemukan.')->withInput();
        }

        // Generate 6-digit OTP
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session
        Session::put('admin_reset_code', $code);
        Session::put('admin_reset_email', $request->email);
        Session::put('admin_reset_admin_id', $admin->id);
        Session::put('admin_reset_expires', now()->addMinutes(15));

        // Send Email
        try {
            Mail::to($request->email)->send(new AdminResetPasswordMail($code));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.password.reset.form')->with('admin_reset_code_sent', true);
    }

    /**
     * Show reset form (enter OTP + new password).
     */
    public function showResetForm()
    {
        if (!Session::has('admin_reset_email')) {
            return redirect()->route('admin.password.forgot');
        }

        return view('admin.reset-password');
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

        // Verify OTP
        if ($request->code !== Session::get('admin_reset_code')) {
            return back()->with('error', 'Kode verifikasi salah.')->withInput();
        }

        // Check expiry
        if (now()->isAfter(Session::get('admin_reset_expires'))) {
            Session::forget(['admin_reset_code', 'admin_reset_email', 'admin_reset_admin_id', 'admin_reset_expires']);
            return redirect()->route('admin.password.forgot')->with('error', 'Kode sudah expired. Silakan minta kode baru.');
        }

        // Update admin password
        $admin = Admin::find(Session::get('admin_reset_admin_id'));
        if (!$admin) {
            return redirect()->route('admin.password.forgot')->with('error', 'Akun admin tidak ditemukan.');
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear reset session
        Session::forget(['admin_reset_code', 'admin_reset_email', 'admin_reset_admin_id', 'admin_reset_expires']);

        return redirect()->route('admin.login')->with('success', 'Password admin berhasil direset! Silakan login dengan password baru.');
    }
}
