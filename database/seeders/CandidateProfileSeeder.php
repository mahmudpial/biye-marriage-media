<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateProfileSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
            [
                'profile_code' => 'BD-ELT-9041',
                'gender' => 'female',
                'age' => 26,
                'height' => "5'5\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Sylhet / Dhaka',
                'education' => 'BSc London School of Economics (LSE)',
                'profession' => 'Senior Strategy Consultant, Multinational Firm',
                'location' => 'Gulshan-2, Dhaka',
                'income' => '৳45 Lakhs+',
                'category' => 'Elite Professional',
                'family' => 'Prominent Tea Estate & Export Business Family in Sylhet & Dhaka',
                'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => true,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'profile_code' => 'BD-ELT-8120',
                'gender' => 'male',
                'age' => 30,
                'height' => "5'11\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Chattogram',
                'education' => 'MBA Columbia University, BBA IBA (Dhaka University)',
                'profession' => 'Deputy Managing Director, Steel & Shipping Conglomerate',
                'location' => 'Khulshi, Chattogram / Baridhara',
                'income' => '৳1.8 Crore+',
                'category' => 'Elite Business',
                'family' => '3rd Generation Industrial House, Listed Commercial Group',
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => true,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'profile_code' => 'BD-ELT-7319',
                'gender' => 'female',
                'age' => 28,
                'height' => "5'4\"",
                'religion' => 'Islam (Deen-conscious)',
                'desher_bari' => 'Dhaka / Cumilla',
                'education' => 'MBBS (Dhaka Medical College), FCPS Part-II',
                'profession' => 'Resident Physician & Health Tech Researcher',
                'location' => 'Dhanmondi, Dhaka',
                'income' => '৳35 Lakhs+',
                'category' => 'Elite Professional',
                'family' => 'Highly Respected Doctors & Senior Bureaucrat Family',
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => false,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'profile_code' => 'BD-ELT-9552',
                'gender' => 'male',
                'age' => 31,
                'height' => "6'0\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Dhaka (Old Dhaka Heritage)',
                'education' => 'B.Sc. Civil Engineering (BUET), M.S. Stanford University',
                'profession' => 'Founder & CEO, Green Tech Infrastructure (Funded)',
                'location' => 'Baridhara DOHS, Dhaka',
                'income' => '৳2.2 Crore+',
                'category' => 'Elite Aristocrat',
                'family' => 'Distinguished Zamindar Lineage & Leading Real Estate Developers',
                'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => true,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'profile_code' => 'BD-ELT-6410',
                'gender' => 'female',
                'age' => 27,
                'height' => "5'6\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Mymensingh / Dhaka',
                'education' => 'BCS Administration Cadre (Top 10), MA Dhaka University',
                'profession' => 'Senior Assistant Commissioner / Executive Magistrate',
                'location' => 'Banani, Dhaka',
                'income' => 'Government Gazette Grade',
                'category' => 'Elite Professional',
                'family' => 'Former Secretary & Judicial Service Distinguished Lineage',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => false,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'profile_code' => 'BD-ELT-3814',
                'gender' => 'male',
                'age' => 32,
                'height' => "5'10\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Sylhet (UK NRB)',
                'education' => 'MSc Finance, University of Oxford',
                'profession' => 'Vice President, Investment Banking (Canary Wharf)',
                'location' => 'London, UK & Upashahar, Sylhet',
                'income' => '£180,000 (~৳2.8 Crore)',
                'category' => 'Elite Aristocrat',
                'family' => 'Established British-Bangladeshi Business Empire & Landowners',
                'image' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=800&q=80',
                'is_discreet' => true,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($profiles as $profile) {
            CandidateProfile::updateOrCreate(
                ['profile_code' => $profile['profile_code']],
                $profile
            );
        }
    }
}
