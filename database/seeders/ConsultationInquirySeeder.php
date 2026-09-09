<?php

namespace Database\Seeders;

use App\Models\ConsultationInquiry;
use Illuminate\Database\Seeder;

class ConsultationInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inquiries = [
            [
                'inquiry_code' => 'INQ-901',
                'full_name' => 'Brigadier Gen. (Retd.) Faruq Ahmed',
                'looking_for' => 'Groom',
                'profile_for' => 'Daughter',
                'phone' => '+880 1711-889900',
                'email' => 'faruq.ahmed@example.com',
                'city' => 'Gulshan-2, Dhaka',
                'desher_bari' => 'Cumilla',
                'preferred_package' => 'Elite Aristocrat',
                'annual_income' => '৳75 Lakhs+',
                'message' => 'Seeking alliance for daughter: Doctor, FCPS Part-1. Family prefers established pedigree background.',
                'status' => 'Pending Review',
                'admin_notes' => 'Priority family from DOHS. Callback scheduled today.',
            ],
            [
                'inquiry_code' => 'INQ-902',
                'full_name' => 'Engr. Mahbubul Alam (NRB, Canada)',
                'looking_for' => 'Bride',
                'profile_for' => 'Son',
                'phone' => '+880 1819-223344',
                'email' => 'mahbub.alam@example.com',
                'city' => 'Toronto / Uttara Sec-4',
                'desher_bari' => 'Sylhet',
                'preferred_package' => 'Elite Business',
                'annual_income' => '৳1 Crore+',
                'message' => 'Seeking bride for son: Software Architect in Toronto. Visiting Dhaka next month for in-person meeting.',
                'status' => 'In Progress',
                'admin_notes' => 'Sent package brochure and requirements checklist via WhatsApp.',
            ],
            [
                'inquiry_code' => 'INQ-903',
                'full_name' => 'Mrs. Shamima Nasrin',
                'looking_for' => 'Groom',
                'profile_for' => 'Self',
                'phone' => '+880 1912-334455',
                'email' => 'shamima.nasrin@example.com',
                'city' => 'Dhanmondi, Dhaka',
                'desher_bari' => 'Mymensingh',
                'preferred_package' => 'Elite Professional',
                'annual_income' => '৳35 Lakhs+',
                'message' => 'BCS Admin Cadre officer looking for an educated partner from respected lineage.',
                'status' => 'Contacted',
                'admin_notes' => 'Initial phone interview conducted. Awaiting biodata submission.',
            ],
            [
                'inquiry_code' => 'INQ-904',
                'full_name' => 'Dr. Kazi Rafiqul Islam',
                'looking_for' => 'Bride',
                'profile_for' => 'Son',
                'phone' => '+880 1552-445566',
                'email' => 'kazi.rafiq@example.com',
                'city' => 'Khulshi, Chattogram',
                'desher_bari' => 'Chattogram',
                'preferred_package' => 'Elite Aristocrat',
                'annual_income' => '৳80 Lakhs+',
                'message' => 'Son is Cardiologist at BSMMU. Looking for doctor or graduate from established family.',
                'status' => 'Verified',
                'admin_notes' => 'Verified lineage and background. Matchmaking council allocated.',
            ],
        ];

        foreach ($inquiries as $inquiryData) {
            ConsultationInquiry::updateOrCreate(
                ['inquiry_code' => $inquiryData['inquiry_code']],
                $inquiryData
            );
        }
    }
}
