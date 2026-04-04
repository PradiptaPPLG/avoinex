<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share site settings with all views (only if the table exists)
        View::composer('layouts.app', function ($view) {
            try {
                if (Schema::hasTable('site_settings')) {
                    $view->with('siteSettings', SiteSetting::allCached());
                }
            } catch (\Exception $e) {
                $view->with('siteSettings', []);
            }
        });
    }
}
