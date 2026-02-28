<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Client;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed');
        }

        // cari berdasarkan email
        $client = Client::where('email', $googleUser->email)->first();

        if (!$client) {
            // PECAH nama dengan aman
            $names = explode(' ', $googleUser->name, 2);

            $client = Client::create([
                'first_name' => $names[0],
                'last_name'  => $names[1] ?? null,
                'email'      => $googleUser->email,
                'google_id'  => $googleUser->id,
                'profile_completed' => 0,
            ]);
        } else {
            if (!$client->google_id) {
                $client->update([
                    'google_id' => $googleUser->id
                ]);
            }
        }

        // simpan session
        session([
            'client_id' => $client->client_id,
            'client_name' => trim($client->first_name . ' ' . $client->last_name),
            'client_email' => $client->email,
            'client_logged_in' => true
        ]);

       // 🔥 CEK PROFIL

return redirect('/home')
    ->with('success', 'Login with Google successful!');

    }
}
