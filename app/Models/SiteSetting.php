<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    /**
     * Get a setting value by key with optional default.
     */
    public static function getValue(string $key, $default = null)
    {
        $settings = Cache::remember('site_settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value (and bust cache).
     */
    public static function setValue(string $key, $value)
    {
        self::where('key', $key)->update(['value' => $value]);
        Cache::forget('site_settings');
    }

    /**
     * Get all settings as key => value array.
     */
    public static function allCached()
    {
        return Cache::remember('site_settings', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get settings by group.
     */
    public static function getByGroup(string $group)
    {
        return self::where('group', $group)->get();
    }
}
