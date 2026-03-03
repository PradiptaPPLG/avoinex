<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_id')) {
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

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_id', $admin->id);
            Session::put('admin_name', $admin->name);
            Session::put('admin_email', $admin->email);

            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Invalid email or password')->withInput();
    }

    public function dashboard()
    {
        $totalBookings = \App\Models\Booking::count();
        $confirmedBookings = \App\Models\Booking::where('booking_status', 'confirmed')->count();
        $cancelledBookings = \App\Models\Booking::where('booking_status', 'cancelled')->count();
        $totalRevenue = \App\Models\Booking::where('booking_status', 'confirmed')
            ->where('payment_status', 'paid')
            ->sum('total_price_usd');
        $flightsToday = \App\Models\FlightInstance::whereDate('flight_date', today())->count();

        return view('admin.dashboard', compact(
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'totalRevenue',
            'flightsToday'
        ));
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_name', 'admin_email']);
        Session::flush();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
