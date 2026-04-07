<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:45',
            'last_name' => 'nullable|string|max:45',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'passport' => 'required|string|max:45|unique:clients,passport',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $client = Client::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'passport' => $request->passport,
                'iata_country_code' => 'ID',
                'password_hash' => Hash::make($request->password),
                'profile_completed' => 0,
            ]);

            // Auto login setelah registrasi
            session([
                'client_id' => $client->client_id,
                'client_name' => $client->first_name . ' ' . $client->last_name,
                'client_email' => $client->email,
                'client_logged_in' => true
            ]);

            return redirect()->route('home')->with('success', 'Account created successfully! Welcome to Avoinex!');
            
        } catch (\Exception $e) {
            Log::error('Registration error:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }
}