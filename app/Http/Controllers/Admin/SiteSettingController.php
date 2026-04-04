<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $groups = [
            'security' => ['label' => 'Security & Recovery', 'icon' => 'bi-shield-lock-fill', 'description' => 'Email pemulihan untuk reset password admin. Pastikan email ini aktif dan bisa menerima kode OTP.'],
            'social'  => ['label' => 'Social Media', 'icon' => 'bi-share-fill', 'description' => 'Link media sosial yang akan ditampilkan di footer website.'],
            'contact' => ['label' => 'Contact Info', 'icon' => 'bi-headset', 'description' => 'Informasi kontak perusahaan.'],
            'footer'  => ['label' => 'Footer Content', 'icon' => 'bi-layout-text-window-reverse', 'description' => 'Teks dan konten yang ditampilkan di bagian bawah website.'],
        ];

        $settings = SiteSetting::all()->groupBy('group');

        return view('admin.settings.index', compact('groups', 'settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');

        foreach ($data as $key => $value) {
            SiteSetting::where('key', $key)->update(['value' => $value ?? '']);
        }

        // Clear cached settings
        \Illuminate\Support\Facades\Cache::forget('site_settings');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
