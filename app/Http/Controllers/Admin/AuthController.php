<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\FlightInstance;
use Carbon\Carbon;

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
        // ======= STAT CARDS =======
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('booking_status', 'confirmed')->count();
        $cancelledBookings = Booking::where('booking_status', 'cancelled')->count();
        $pendingBookings = Booking::where('booking_status', 'pending')->count();
        $totalRevenue = Booking::where('booking_status', 'confirmed')
            ->where('payment_status', 'paid')
            ->sum('total_price_usd');
        $flightsToday = FlightInstance::whereDate('flight_date', today())->count();

        // ======= CHART DATA: Revenue Trend (6 months) =======
        $revenueMonths = [];
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenueMonths[] = $month->format('M Y');
            $revenueData[] = Booking::where('booking_status', 'confirmed')
                ->where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_price_usd');
        }

        // ======= CHART DATA: Bookings Per Month (6 months) =======
        $bookingMonths = $revenueMonths; // Same months
        $bookingData = [];
        $bookingConfirmedData = [];
        $bookingCancelledData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $bookingData[] = Booking::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $bookingConfirmedData[] = Booking::where('booking_status', 'confirmed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $bookingCancelledData[] = Booking::where('booking_status', 'cancelled')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // ======= CHART DATA: Booking Status Distribution =======
        $statusDistribution = [
            'confirmed' => $confirmedBookings,
            'pending' => $pendingBookings,
            'cancelled' => $cancelledBookings,
        ];

        // ======= CHART DATA: Top 5 Routes =======
        $topRoutes = Booking::join('flight_instances', 'bookings.flight_instance_id', '=', 'flight_instances.flight_instance_id')
            ->join('schedules', 'flight_instances.schedule_id', '=', 'schedules.schedule_id')
            ->join('airports as origin', 'schedules.origin_iata_code', '=', 'origin.iata_code')
            ->join('airports as dest', 'schedules.destination_iata_code', '=', 'dest.iata_code')
            ->select(
                DB::raw("CONCAT(origin.city, ' → ', dest.city) as route"),
                DB::raw('COUNT(*) as total')
            )
            ->where('bookings.booking_status', '!=', 'cancelled')
            ->groupBy('route')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topRouteLabels = $topRoutes->pluck('route')->toArray();
        $topRouteValues = $topRoutes->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'totalBookings',
            'confirmedBookings',
            'cancelledBookings',
            'pendingBookings',
            'totalRevenue',
            'flightsToday',
            'revenueMonths',
            'revenueData',
            'bookingMonths',
            'bookingData',
            'bookingConfirmedData',
            'bookingCancelledData',
            'statusDistribution',
            'topRouteLabels',
            'topRouteValues'
        ));
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_name', 'admin_email']);
        Session::flush();

        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
