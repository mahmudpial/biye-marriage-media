<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard overview.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'verified_profiles' => 1250,
            'pending_leads' => 14,
            'active_packages' => 3,
            'monthly_matches' => 88,
        ];

        $recentInquiries = [
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

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentInquiries' => $recentInquiries,
        ]);
    }
}
