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

            // Hero Section
            [
                'key' => 'hero_badge',
                'value' => '100% Confidential Service',
                'group' => 'hero',
                'type' => 'text',
            ],
            [
                'key' => 'hero_title',
                'value' => 'Find Your Perfect Life Partner with <span class="text-gold font-serif fst-italic">Trust & Confidentiality</span>',
                'group' => 'hero',
                'type' => 'text',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal match.',
                'group' => 'hero',
                'type' => 'textarea',
            ],
            [
                'key' => 'hero_cta_primary_text',
                'value' => 'Register Profile',
                'group' => 'hero',
                'type' => 'text',
            ],
            [
                'key' => 'hero_cta_secondary_text',
                'value' => 'Contact Us',
                'group' => 'hero',
                'type' => 'text',
            ],
            [
                'key' => 'hero_features',
                'value' => json_encode([
                    ['icon' => 'bi-shield-lock-fill', 'title' => '100% Confidential Service', 'desc' => 'Your privacy & identity always protected'],
                    ['icon' => 'bi-patch-check-fill', 'title' => 'Verified Profiles', 'desc' => 'Genuine & authentic matches'],
                    ['icon' => 'bi-moon-stars-fill', 'title' => 'Islamic Matchmaking', 'desc' => 'Focus on shared Islamic values'],
                    ['icon' => 'bi-globe-americas', 'title' => 'Bangladesh & Overseas', 'desc' => 'Connecting families locally & globally'],
                ]),
                'group' => 'hero',
                'type' => 'json',
            ],

            // Our Specialties Section
            [
                'key' => 'specialties_tag',
                'value' => 'Our Specialties',
                'group' => 'specialties',
                'type' => 'text',
            ],
            [
                'key' => 'specialties_title',
                'value' => 'Professional Matchmaking Services Tailored For You',
                'group' => 'specialties',
                'type' => 'text',
            ],
            [
                'key' => 'specialties_desc',
                'value' => 'Built on trust, Islamic values, and deep family compatibility for clients in Bangladesh and overseas.',
                'group' => 'specialties',
                'type' => 'textarea',
            ],
            [
                'key' => 'specialties_items',
                'value' => json_encode([
                    [
                        'icon' => 'bi-shield-lock-fill',
                        'title' => '100% Confidential Service',
                        'desc' => 'Your privacy and identity are always protected with strict non-disclosure protocols and private profile sharing.',
                    ],
                    [
                        'icon' => 'bi-heart-pulse-fill',
                        'title' => 'Bride & Groom Matching',
                        'desc' => 'Dedicated specialized services for finding the right groom (Patro) or bride (Patri) with complete peace of mind.',
                    ],
                    [
                        'icon' => 'bi-sliders',
                        'title' => 'Personalized Matchmaking',
                        'desc' => 'Tailored searches based on your specific lifestyle, cultural preferences, district roots (Desher Bari), and expectations.',
                    ],
                    [
                        'icon' => 'bi-moon-stars-fill',
                        'title' => 'Islamic Matchmaking',
                        'desc' => 'A core focus on shared Islamic values, Deen-conscious lifestyles, family guardian (Wali) coordination, and noble traditions.',
                    ],
                    [
                        'icon' => 'bi-person-check-fill',
                        'title' => 'Professional Marriage Consultancy',
                        'desc' => 'Expert guidance throughout your partner search with dedicated, experienced marriage consultants and advisors.',
                    ],
                    [
                        'icon' => 'bi-globe-americas',
                        'title' => 'Bangladesh & Overseas Matchmaking',
                        'desc' => 'Connecting families locally across Bangladesh and globally across the UK, USA, Canada, UAE, Australia, and European diaspora.',
                    ],
                ]),
                'group' => 'specialties',
                'type' => 'json',
            ],

            // Seamless Process Section
            [
                'key' => 'process_tag',
                'value' => 'Seamless Process',
                'group' => 'process',
                'type' => 'text',
            ],
            [
                'key' => 'process_title',
                'value' => 'How Our Private Matchmaking Works',
                'group' => 'process',
                'type' => 'text',
            ],
            [
                'key' => 'process_desc',
                'value' => 'From initial confidential consultation to alliance celebrations, experience personalized attention at every step.',
                'group' => 'process',
                'type' => 'textarea',
            ],
            [
                'key' => 'process_cta_text',
                'value' => 'Schedule Your Family Consultation',
                'group' => 'process',
                'type' => 'text',
            ],
            [
                'key' => 'process_steps',
                'value' => json_encode([
                    [
                        'number' => '01',
                        'title' => 'Understanding Family Expectations',
                        'desc' => 'Your Relationship Manager hosts an in-depth private consultation at your residence or club to understand your family values, district preference (Desher Bari), and partner requirements.',
                    ],
                    [
                        'number' => '02',
                        'title' => 'Handpicking Verified Recommendations',
                        'desc' => 'Your Relationship Manager rigorously filters verified high-caliber profiles from our private registry and presents curated executive briefs directly to family guardians.',
                    ],
                    [
                        'number' => '03',
                        'title' => 'Facilitating High-Level Introductions',
                        'desc' => 'Upon mutual interest, your Relationship Manager coordinates confidential family meetings at premier 5-star venues (Radisson, Westin, InterContinental) or private family lounges.',
                    ],
                ]),
                'group' => 'process',
                'type' => 'json',
            ],

            // About Section & Page
            [
                'key' => 'about_hero_badge',
                'value' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_hero_title',
                'value' => 'About Biye Marriage Media',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_hero_subtitle',
                'value' => 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner.',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_heritage_tag',
                'value' => 'About Biye Marriage Media',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_heritage_title',
                'value' => 'Built on Trust, Islamic Values & Deep Family Compatibility',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_heritage_p1',
                'value' => 'At Biye Marriage Media, we believe that a successful marriage is built on trust, Islamic values, and deep family compatibility. We operate as professional marriage consultants dedicated to providing a safe, secure, and 100% confidential platform for bride and groom matching.',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_heritage_p2',
                'value' => 'Whether you are looking for a match within Bangladesh or seeking expatriate profiles overseas, our verified matchmaking process ensures you find the perfect life partner with complete peace of mind. We understand that finding a life partner is a deeply sacred family journey that demands the highest standards of discretion and respect.',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_wedding_quote',
                'value' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী — Dedicated to creating blessed, honorable, and lifelong marital unions.',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_pillars_tag',
                'value' => 'Core Principles',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_pillars_title',
                'value' => 'The Cornerstones of Our Service',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_pillars_desc',
                'value' => 'Every member experiences our three unshakeable commitments to prestige and privacy.',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_pillars',
                'value' => json_encode([
                    [
                        'icon' => 'bi-eye-slash-fill',
                        'title' => 'Uncompromising Discretion',
                        'desc' => 'Your identity, photographs, and family credentials are never displayed publicly. Information is shared only upon bilateral consent between both prospective families.',
                    ],
                    [
                        'icon' => 'bi-person-hearts',
                        'title' => 'In-Person Relationship Care',
                        'desc' => 'Our seasoned Relationship Managers come from your region, appreciate cultural nuances, visit your residence, and coordinate all prospective communications.',
                    ],
                    [
                        'icon' => 'bi-patch-check-fill',
                        'title' => 'Rigorous Vetting Process',
                        'desc' => 'Every profile undergoes deep verification covering educational degrees (BUET/IBA/DMC/Abroad), financial assets/income, corporate standing, and family reputation.',
                    ],
                ]),
                'group' => 'about',
                'type' => 'json',
            ],
            [
                'key' => 'about_concierge_tag',
                'value' => 'Personalized Concierge',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_concierge_title',
                'value' => 'Your Private Matchmaker & Family Confidant',
                'group' => 'about',
                'type' => 'text',
            ],
            [
                'key' => 'about_concierge_desc',
                'value' => 'Finding the right life partner is a deeply personal and family-centered journey. Our matchmakers act as private advisors:',
                'group' => 'about',
                'type' => 'textarea',
            ],
            [
                'key' => 'about_concierge_points',
                'value' => json_encode([
                    [
                        'title' => 'In-Home Consultations',
                        'desc' => 'We meet your family at your residence in Gulshan, Banani, Baridhara, Dhanmondi, DOHS, or Khulshi to understand preferences, traditions, and lifestyle expectations.',
                    ],
                    [
                        'title' => 'Weekly Curated Portfolios',
                        'desc' => 'Receive handpicked, thoroughly screened executive briefs tailored to your specific criteria.',
                    ],
                    [
                        'title' => 'Bespoke Meeting Coordination',
                        'desc' => 'We facilitate respectful, confidential interactions in premier five-star venues (Radisson, Westin, InterContinental) or private family lounges.',
                    ],
                ]),
                'group' => 'about',
                'type' => 'json',
            ],

            // Final VIP CTA Section
            [
                'key' => 'final_cta_badge',
                'value' => 'Begin Your Exclusive Journey',
                'group' => 'final_cta',
                'type' => 'text',
            ],
            [
                'key' => 'final_cta_title',
                'value' => 'Ready to Find the Ideal Match for Your Family?',
                'group' => 'final_cta',
                'type' => 'text',
            ],
            [
                'key' => 'final_cta_subtitle',
                'value' => 'Speak directly with an Executive Matchmaker who will handle your family preferences with absolute privacy, cultural respect, and dedicated care.',
                'group' => 'final_cta',
                'type' => 'textarea',
            ],
            [
                'key' => 'final_cta_button_text',
                'value' => 'Request VIP Callback',
                'group' => 'final_cta',
                'type' => 'text',
            ],

            // Footer Section
            [
                'key' => 'footer_copyright_text',
                'value' => 'All rights reserved. Private family matchmaking services.',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_trust_title',
                'value' => '100% Confidential',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_trust_subtitle',
                'value' => 'Islamic Values & Verified Matchmaking',
                'group' => 'footer',
                'type' => 'text',
            ],
            [
                'key' => 'footer_presence_note',
                'value' => 'Services: Bangladesh & Overseas Matchmaking',
                'group' => 'footer',
                'type' => 'text',
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
