<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General & Brand Identity
            [
                'key' => 'site_name',
                'value' => 'Biye Marriage Media',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
                'group' => 'general',
                'type' => 'text',
            ],
            [
                'key' => 'about_summary',
                'value' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner with 100% confidentiality.',
                'group' => 'general',
                'type' => 'textarea',
            ],

            // Contact & Regional Helpline
            [
                'key' => 'contact_phone',
                'value' => '+880 1577-723404',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '8801577723404',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'contact_email',
                'value' => 'biyemarriagemedia@gmail.com',
                'group' => 'contact',
                'type' => 'text',
            ],
            [
                'key' => 'office_address',
                'value' => 'Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka, Bangladesh, 1212',
                'group' => 'contact',
                'type' => 'textarea',
            ],
            [
                'key' => 'office_hours',
                'value' => 'Saturday to Friday, 9:00 AM - 10:00 PM BST',
                'group' => 'contact',
                'type' => 'text',
            ],

            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/biyemarriagemedia',
                'group' => 'social',
                'type' => 'text',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com',
                'group' => 'social',
                'type' => 'text',
            ],
            [
                'key' => 'whatsapp_url',
                'value' => 'https://wa.me/8801577723404',
                'group' => 'social',
                'type' => 'text',
            ],
            [
                'key' => 'youtube_url',
                'value' => '',
                'group' => 'social',
                'type' => 'text',
            ],

            // Announcement Marquee Bar
            [
                'key' => 'announcement_enabled',
                'value' => '0',
                'group' => 'announcement',
                'type' => 'boolean',
            ],
            [
                'key' => 'announcement_text',
                'value' => 'Special NRB Matrimonial Salon Sessions Open in Dhaka & London - Schedule via VIP Concierge',
                'group' => 'announcement',
                'type' => 'textarea',
            ],
            [
                'key' => 'announcement_link',
                'value' => '/contact',
                'group' => 'announcement',
                'type' => 'text',
            ],

            // SEO & Meta
            [
                'key' => 'meta_title_suffix',
                'value' => 'Biye Marriage Media | বিশ্বাসের বন্ধনে, সুন্দর আগামী',
                'group' => 'seo',
                'type' => 'text',
            ],
            [
                'key' => 'meta_description',
                'value' => 'Premier matrimonial matchmaking service in Bangladesh and for overseas NRBs. High-society, Islamic values, verified pedigree, and 100% confidential bride & groom matching.',
                'group' => 'seo',
                'type' => 'textarea',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                ]
            );
        }

        SiteSetting::clearCache();
    }
}
