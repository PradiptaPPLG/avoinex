<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, social, footer, contact
            $table->string('label')->nullable();
            $table->string('type')->default('text');     // text, url, textarea, email
            $table->timestamps();
        });

        // Seed default settings
        $settings = [
            // Social Media
            ['key' => 'social_instagram', 'value' => '#', 'group' => 'social', 'label' => 'Instagram URL', 'type' => 'url'],
            ['key' => 'social_facebook', 'value' => '#', 'group' => 'social', 'label' => 'Facebook URL', 'type' => 'url'],
            ['key' => 'social_twitter', 'value' => '#', 'group' => 'social', 'label' => 'Twitter / X URL', 'type' => 'url'],
            ['key' => 'social_youtube', 'value' => '#', 'group' => 'social', 'label' => 'YouTube URL', 'type' => 'url'],
            ['key' => 'social_tiktok', 'value' => '#', 'group' => 'social', 'label' => 'TikTok URL', 'type' => 'url'],
            ['key' => 'social_whatsapp', 'value' => '#', 'group' => 'social', 'label' => 'WhatsApp URL / Number', 'type' => 'url'],

            // Contact Info
            ['key' => 'contact_email', 'value' => 'support@avoinex.com', 'group' => 'contact', 'label' => 'Email Kontak', 'type' => 'email'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234 5678', 'group' => 'contact', 'label' => 'Nomor Telepon', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'group' => 'contact', 'label' => 'Alamat Kantor', 'type' => 'textarea'],

            // Footer
            ['key' => 'footer_tagline', 'value' => 'Your Trusted Partner for Smarter, Easier, and More Affordable Flight Booking.', 'group' => 'footer', 'label' => 'Footer Tagline', 'type' => 'textarea'],
            ['key' => 'footer_copyright', 'value' => '© 2026 Avoinex Airlines. All Rights Reserved.', 'group' => 'footer', 'label' => 'Copyright Text', 'type' => 'text'],
        ];

        $now = now();
        foreach ($settings as &$s) {
            $s['created_at'] = $now;
            $s['updated_at'] = $now;
        }

        DB::table('site_settings')->insert($settings);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
