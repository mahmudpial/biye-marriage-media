<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Default fallbacks to guarantee application availability even before migration/seeding.
     */
    public const DEFAULTS = [
        // General & Brand Identity
        'site_name' => 'Biye Marriage Media',
        'site_tagline' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
        'about_summary' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner with 100% confidentiality.',

        // Contact & Regional Helpline
        'contact_phone' => '+880 1577-723404',
        'whatsapp_number' => '8801577723404',
        'contact_email' => 'biyemarriagemedia@gmail.com',
        'office_address' => 'Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka, Bangladesh, 1212',
        'office_hours' => 'Saturday to Friday, 9:00 AM - 10:00 PM BST',

        // Social Links
        'facebook_url' => 'https://www.facebook.com/biyemarriagemedia',
        'instagram_url' => 'https://instagram.com',
        'whatsapp_url' => 'https://wa.me/8801577723404',
        'youtube_url' => '',

        // Announcement Marquee Bar
        'announcement_enabled' => '0',
        'announcement_text' => 'Special NRB Matrimonial Salon Sessions Open in Dhaka & London - Schedule via VIP Concierge',
        'announcement_link' => '/contact',

        // SEO & Meta
        'meta_title_suffix' => 'Biye Marriage Media | বিশ্বাসের বন্ধনে, সুন্দর আগামী',
        'meta_description' => 'Premier matrimonial matchmaking service in Bangladesh and for overseas NRBs. High-society, Islamic values, verified pedigree, and 100% confidential bride & groom matching.',
    ];

    /**
     * Local in-memory runtime cache to eliminate redundant database queries per request.
     *
     * @var array<string, mixed>|null
     */
    protected static ?array $cachedSettings = null;

    /**
     * Retrieve a setting by key with optional fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::allAsArray();

        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return static::DEFAULTS[$key] ?? $default;
    }

    /**
     * Store or update a setting by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => (string) $value,
                'group' => $group,
                'type' => $type,
            ]
        );

        static::clearCache();

        return $setting;
    }

    /**
     * Retrieve all settings as an associative key => value array, merged with defaults.
     *
     * @return array<string, mixed>
     */
    public static function allAsArray(): array
    {
        if (static::$cachedSettings !== null) {
            return static::$cachedSettings;
        }

        $merged = static::DEFAULTS;

        try {
            $dbSettings = static::all();
            foreach ($dbSettings as $setting) {
                $merged[$setting->key] = $setting->value;
            }
        } catch (\Throwable $e) {
            // If table does not exist or database is unreachable, fallback to static defaults
            Log::debug('SiteSetting fallback used: '.$e->getMessage());
        }

        static::$cachedSettings = $merged;

        return static::$cachedSettings;
    }

    /**
     * Clear the in-memory runtime cache.
     */
    public static function clearCache(): void
    {
        static::$cachedSettings = null;
    }
}
