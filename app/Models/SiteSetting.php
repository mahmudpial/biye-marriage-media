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

        // Hero Section
        'hero_badge' => '100% Confidential Service',
        'hero_title' => 'Find Your Perfect Life Partner with <span class="text-gold font-serif fst-italic">Trust & Confidentiality</span>',
        'hero_subtitle' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal match.',
        'hero_cta_primary_text' => 'Register Profile',
        'hero_cta_secondary_text' => 'Contact Us',
        'hero_features' => '[{"icon":"bi-shield-lock-fill","title":"100% Confidential Service","desc":"Your privacy & identity always protected"},{"icon":"bi-patch-check-fill","title":"Verified Profiles","desc":"Genuine & authentic matches"},{"icon":"bi-moon-stars-fill","title":"Islamic Matchmaking","desc":"Focus on shared Islamic values"},{"icon":"bi-globe-americas","title":"Bangladesh & Overseas","desc":"Connecting families locally & globally"}]',

        // Our Specialties Section
        'specialties_tag' => 'Our Specialties',
        'specialties_title' => 'Professional Matchmaking Services Tailored For You',
        'specialties_desc' => 'Built on trust, Islamic values, and deep family compatibility for clients in Bangladesh and overseas.',
        'specialties_items' => '[{"icon":"bi-shield-lock-fill","title":"100% Confidential Service","desc":"Your privacy and identity are always protected with strict non-disclosure protocols and private profile sharing."},{"icon":"bi-heart-pulse-fill","title":"Bride & Groom Matching","desc":"Dedicated specialized services for finding the right groom (Patro) or bride (Patri) with complete peace of mind."},{"icon":"bi-sliders","title":"Personalized Matchmaking","desc":"Tailored searches based on your specific lifestyle, cultural preferences, district roots (Desher Bari), and expectations."},{"icon":"bi-moon-stars-fill","title":"Islamic Matchmaking","desc":"A core focus on shared Islamic values, Deen-conscious lifestyles, family guardian (Wali) coordination, and noble traditions."},{"icon":"bi-person-check-fill","title":"Professional Marriage Consultancy","desc":"Expert guidance throughout your partner search with dedicated, experienced marriage consultants and advisors."},{"icon":"bi-globe-americas","title":"Bangladesh & Overseas Matchmaking","desc":"Connecting families locally across Bangladesh and globally across the UK, USA, Canada, UAE, Australia, and European diaspora."}]',

        // Seamless Process Section ("How Our Private Matchmaking Works")
        'process_tag' => 'Seamless Process',
        'process_title' => 'How Our Private Matchmaking Works',
        'process_desc' => 'From initial confidential consultation to alliance celebrations, experience personalized attention at every step.',
        'process_cta_text' => 'Schedule Your Family Consultation',
        'process_steps' => '[{"number":"01","title":"Understanding Family Expectations","desc":"Your Relationship Manager hosts an in-depth private consultation at your residence or club to understand your family values, district preference (Desher Bari), and partner requirements."},{"number":"02","title":"Handpicking Verified Recommendations","desc":"Your Relationship Manager rigorously filters verified high-caliber profiles from our private registry and presents curated executive briefs directly to family guardians."},{"number":"03","title":"Facilitating High-Level Introductions","desc":"Upon mutual interest, your Relationship Manager coordinates confidential family meetings at premier 5-star venues (Radisson, Westin, InterContinental) or private family lounges."}]',

        // About Section & Page
        'about_hero_badge' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
        'about_hero_title' => 'About Biye Marriage Media',
        'about_hero_subtitle' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner.',
        'about_heritage_tag' => 'About Biye Marriage Media',
        'about_heritage_title' => 'Built on Trust, Islamic Values & Deep Family Compatibility',
        'about_heritage_p1' => 'At Biye Marriage Media, we believe that a successful marriage is built on trust, Islamic values, and deep family compatibility. We operate as professional marriage consultants dedicated to providing a safe, secure, and 100% confidential platform for bride and groom matching.',
        'about_heritage_p2' => 'Whether you are looking for a match within Bangladesh or seeking expatriate profiles overseas, our verified matchmaking process ensures you find the perfect life partner with complete peace of mind. We understand that finding a life partner is a deeply sacred family journey that demands the highest standards of discretion and respect.',
        'about_wedding_quote' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী — Dedicated to creating blessed, honorable, and lifelong marital unions.',
        'about_pillars_tag' => 'Core Principles',
        'about_pillars_title' => 'The Cornerstones of Our Service',
        'about_pillars_desc' => 'Every member experiences our three unshakeable commitments to prestige and privacy.',
        'about_pillars' => '[{"icon":"bi-eye-slash-fill","title":"Uncompromising Discretion","desc":"Your identity, photographs, and family credentials are never displayed publicly. Information is shared only upon bilateral consent between both prospective families."},{"icon":"bi-person-hearts","title":"In-Person Relationship Care","desc":"Our seasoned Relationship Managers come from your region, appreciate cultural nuances, visit your residence, and coordinate all prospective communications."},{"icon":"bi-patch-check-fill","title":"Rigorous Vetting Process","desc":"Every profile undergoes deep verification covering educational degrees (BUET/IBA/DMC/Abroad), financial assets/income, corporate standing, and family reputation."}]',
        'about_concierge_tag' => 'Personalized Concierge',
        'about_concierge_title' => 'Your Private Matchmaker & Family Confidant',
        'about_concierge_desc' => 'Finding the right life partner is a deeply personal and family-centered journey. Our matchmakers act as private advisors:',
        'about_concierge_points' => '[{"title":"In-Home Consultations","desc":"We meet your family at your residence in Gulshan, Banani, Baridhara, Dhanmondi, DOHS, or Khulshi to understand preferences, traditions, and lifestyle expectations."},{"title":"Weekly Curated Portfolios","desc":"Receive handpicked, thoroughly screened executive briefs tailored to your specific criteria."},{"title":"Bespoke Meeting Coordination","desc":"We facilitate respectful, confidential interactions in premier five-star venues (Radisson, Westin, InterContinental) or private family lounges."}]',

        // Final VIP CTA Section
        'final_cta_badge' => 'Begin Your Exclusive Journey',
        'final_cta_title' => 'Ready to Find the Ideal Match for Your Family?',
        'final_cta_subtitle' => 'Speak directly with an Executive Matchmaker who will handle your family preferences with absolute privacy, cultural respect, and dedicated care.',
        'final_cta_button_text' => 'Request VIP Callback',

        // Footer Section
        'footer_copyright_text' => 'All rights reserved. Private family matchmaking services.',
        'footer_trust_title' => '100% Confidential',
        'footer_trust_subtitle' => 'Islamic Values & Verified Matchmaking',
        'footer_presence_note' => 'Services: Bangladesh & Overseas Matchmaking',
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
     * Retrieve a JSON setting decoded as an associative array with optional fallback.
     *
     * @param  array<int|string, mixed>  $default
     * @return array<int|string, mixed>
     */
    public static function getJson(string $key, array $default = []): array
    {
        $raw = static::get($key);

        if (empty($raw)) {
            return $default;
        }

        if (is_array($raw)) {
            return $raw;
        }

        $decoded = json_decode((string) $raw, true);

        return is_array($decoded) ? $decoded : $default;
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
