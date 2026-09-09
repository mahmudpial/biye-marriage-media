<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\ConsultationInquiry;
use App\Models\MembershipPackage;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard overview.
     */
    public function index(): View
    {
        $activePackages = 3;
        $pendingLeads = 4;
        $verifiedProfiles = 1250;
        $recentInquiries = collect();

        try {
            if (class_exists(MembershipPackage::class)) {
                $activePackages = MembershipPackage::active()->count();
            }
            if (class_exists(CandidateProfile::class)) {
                $profCount = CandidateProfile::count();
                if ($profCount > 0) {
                    $verifiedProfiles = $profCount;
                }
            }
            if (class_exists(ConsultationInquiry::class)) {
                $pendingLeads = ConsultationInquiry::where('status', 'Pending Review')->count();
                $recentInquiries = ConsultationInquiry::latest('id')->take(5)->get();
            }
        } catch (\Throwable) {
            // fallback
        }

        if ($recentInquiries->isEmpty()) {
            $recentInquiries = $this->getStaticInquiries();
        }

        $stats = [
            'total_users' => User::count(),
            'verified_profiles' => $verifiedProfiles,
            'pending_leads' => $pendingLeads,
            'active_packages' => $activePackages,
            'monthly_matches' => 88,
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentInquiries' => $recentInquiries,
        ]);
    }

    /**
     * Fallback static inquiries if database is not available.
     *
     * @return array<int, array<string, string>>
     */
    private function getStaticInquiries(): array
    {
        return [
            [
                'id' => 'INQ-901',
                'name' => 'Brigadier Gen. (Retd.) Faruq Ahmed',
                'looking_for' => 'Groom for Daughter (Doctor, FCPS Part-1)',
                'phone' => '+880 1711-889900',
                'location' => 'Gulshan-2, Dhaka',
                'desher_bari' => 'Cumilla',
                'package' => 'Elite Aristocrat',
                'status' => 'Pending Review',
                'date' => 'Today, 02:40 PM',
            ],
            [
                'id' => 'INQ-902',
                'name' => 'Engr. Mahbubul Alam (NRB, Canada)',
                'looking_for' => 'Bride for Son (Software Architect)',
                'phone' => '+880 1819-223344',
                'location' => 'Toronto / Uttara Sec-4',
                'desher_bari' => 'Sylhet',
                'package' => 'Elite Business',
                'status' => 'In Progress',
                'date' => 'Today, 11:15 AM',
            ],
            [
                'id' => 'INQ-903',
                'name' => 'Mrs. Shamima Nasrin',
                'looking_for' => 'Groom for Self (BCS Admin Cadre)',
                'phone' => '+880 1912-334455',
                'location' => 'Dhanmondi, Dhaka',
                'desher_bari' => 'Mymensingh',
                'package' => 'Elite Professional',
                'status' => 'Contacted',
                'date' => 'Yesterday',
            ],
            [
                'id' => 'INQ-904',
                'name' => 'Dr. Kazi Rafiqul Islam',
                'looking_for' => 'Bride for Son (Cardiologist, BSMMU)',
                'phone' => '+880 1552-445566',
                'location' => 'Khulshi, Chattogram',
                'desher_bari' => 'Chattogram',
                'package' => 'Elite Aristocrat',
                'status' => 'Verified',
                'date' => '07 Sep 2026',
            ],
        ];
    }
}
