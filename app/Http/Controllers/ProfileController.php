<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Booking;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function show()
    {
        if (!session('client_id')) {
            return redirect()->route('home')->with('error', 'Silakan login terlebih dahulu.');
        }

        $client = Client::with('country')->find(session('client_id'));

        if (!$client) {
            return redirect()->route('home')->with('error', 'Data user tidak ditemukan.');
        }

        // Fetch recent bookings
        $recentBookings = Booking::where('client_id', $client->client_id)
            ->with([
                'flightInstance.schedule.originAirport',
                'flightInstance.schedule.destinationAirport'
            ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stats
        $totalBookings = Booking::where('client_id', $client->client_id)->count();
        $confirmedBookings = Booking::where('client_id', $client->client_id)
            ->where('booking_status', 'confirmed')
            ->count();
        $totalSpent = Booking::where('client_id', $client->client_id)
            ->where('payment_status', 'paid')
            ->sum('total_price_usd');

        return view('pages.profile', compact('client', 'recentBookings', 'totalBookings', 'confirmedBookings', 'totalSpent'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        if (!session('client_id')) {
            return redirect()->route('home');
        }

        $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'required|string|max:45',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        $client = Client::find(session('client_id'));

        if (!$client) {
            return redirect()->route('home')->with('error', 'User tidak ditemukan.');
        }

        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
        ]);

        // Update session name
        session(['client_name' => trim($request->first_name . ' ' . $request->last_name)]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Change user password.
     */
    public function changePassword(Request $request)
    {
        if (!session('client_id')) {
            return redirect()->route('home');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $client = Client::find(session('client_id'));

        if (!$client) {
            return redirect()->route('home')->with('error', 'User tidak ditemukan.');
        }

        // Verify current password
        if (!$client->password_hash || !password_verify($request->current_password, $client->password_hash)) {
            return redirect()->route('profile')->with('error', 'Password lama salah.');
        }

        // Update password
        $client->update([
            'password_hash' => password_hash($request->new_password, PASSWORD_DEFAULT),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diubah!');
    }
}
