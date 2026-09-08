<?php

namespace Database\Seeders;

use App\Models\MembershipPackage;
use Illuminate\Database\Seeder;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'slug' => 'professional',
                'name' => 'Elite Professional',
                'badge' => 'BCS, Medical & Corporate Leaders',
                'price' => '৳60,000 / 6 Months',
                'description' => 'Exclusive matchmaking for top corporate CXOs, BCS Cadres, doctors, engineers, and IBA graduates.',
                'featured' => false,
                'sort_order' => 1,
                'is_active' => true,
                'benefits' => [
                    'Dedicated Senior Relationship Manager in Dhaka / Ctg',
                    'Educational & Income verification (Annual ৳30 Lakhs+)',
                    'Handpicked matches from verified aristocratic families',
                    'Direct coordination with counterpart family matchmakers',
                    'Confidential introductions with mutual profile unlock',
                    'Assistance with initial meeting at premier Dhaka venues',
                ],
            ],
            [
                'slug' => 'business',
                'name' => 'Elite Business',
                'badge' => 'Most Preferred for Industrialists',
                'price' => '৳1,50,000 / Annual Concierge',
                'description' => 'Bespoke services for business owners, directors, and next-gen successors of prominent industrialist families.',
                'featured' => true,
                'sort_order' => 2,
                'is_active' => true,
                'benefits' => [
                    'Principal Relationship Manager with HNI expertise',
                    'In-person family visits in Gulshan, Banani, DOHS, or Khulshi',
                    'Net worth & business asset verification (৳10 Cr - ৳100 Cr+)',
                    'Curated shortlist across Pan-Bangladesh & Global NRBs',
                    'Confidential family meetings at 5-star hotels (Radisson / Westin)',
                    'Discreet family background & lineage (Bongsho) verification',
                    'Optional Shari\'ah-conscious / Deen-compatible matchmaking',
                ],
            ],
            [
                'slug' => 'aristocrat',
                'name' => 'Elite Aristocrat',
                'badge' => 'Ultra High Net-Worth (UHNI)',
                'price' => 'Bespoke UHNI Retainer',
                'description' => 'Flagship concierge for top conglomerate dynasties, eminent landowners, and global NRB elites.',
                'featured' => false,
                'sort_order' => 3,
                'is_active' => true,
                'benefits' => [
                    'Managing Director / Board-level Private Matchmaker',
                    '100% Blind Matching (Strict Non-Disclosure Guarantee)',
                    'Worldwide scouting across London, New York, Toronto & Dubai',
                    'Bespoke high-profile introductions with zero online trace',
                    'Private jet / VIP hospitality coordination for family meetings',
                    'Direct principal-to-principal family council facilitation',
                    'Exclusive invitations to private matrimonial salons in Dhaka',
                ],
            ],
        ];

        foreach ($packages as $pkg) {
            MembershipPackage::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}
