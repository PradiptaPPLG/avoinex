<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required', // bisa email atau phone
            'password' => 'required',
        ]);

        // Cari client berdasarkan email atau phone
        $client = Client::where('email', $request->identifier)
                      ->orWhere('phone', $request->identifier)
                      ->first();

        // Debug: cek apa client ditemukan
        if (!$client) {
            return back()->with('error', 'Email/phone not found');
        }

        // Cek password (perhatikan field di database adalah password_hash)
        if (!password_verify($request->password, $client->password_hash)) {
            return back()->with('error', 'Invalid password');
        }

        // SET SESSION
        session([
            'client_id'        => $client->client_id,
            'client_name'      => trim($client->first_name . ' ' . $client->last_name),
            'client_email'     => $client->email,
            'client_logged_in' => true,
        ]);

        // Redirect ke home setelah login sukses
        return redirect()->route('home')->with('success', 'Welcome back!');
    }

    public function logout(Request $request)
    {
        session()->forget([
            'client_id',
            'client_name',
            'client_email',
            'client_logged_in',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Logged out successfully');
    }
}