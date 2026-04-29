<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Client;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth consent screen.
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle the callback from Google after user selects an account.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        }
        catch (\Exception $e) {
            \Log::error('Google Auth Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()->route('landing')
                ->with('error', 'Google authentication failed. Please try again.');
        }

        // Find existing client by email
        $client = Client::where('email', $googleUser->email)->first();

        if (!$client) {
            // Create new client from Google profile
            $names = explode(' ', $googleUser->name, 2);

            try {
                $client = Client::create([
                    'first_name' => $names[0] ?? 'User',
                    'last_name' => $names[1] ?? null,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                ]);
            }
            catch (\Exception $e) {
                return redirect()->route('landing')
                    ->with('error', 'Failed to create account. Please try again.');
            }
        }
        elseif (!$client->google_id) {
            // Link Google ID to existing account
            $client->update(['google_id' => $googleUser->id]);
        }

        // Set session
        session([
            'client_id' => $client->client_id,
            'client_name' => trim($client->first_name . ' ' . $client->last_name),
            'client_email' => $client->email,
            'client_logged_in' => true,
        ]);

        return redirect()->route('home')
            ->with('success', 'Login with Google successful!');
    }
}
