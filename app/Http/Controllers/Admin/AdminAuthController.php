<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($request->email === 'admin@avoinex.com' && $request->password === 'admin123') {
            session([
                'admin_id' => 1,
                'admin_name' => 'Admin',
                'admin_email' => 'admin@avoinex.com'
            ]);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name', 'admin_email']);
        return redirect('/admin')->with('success', 'Logged out successfully');
    }
}
