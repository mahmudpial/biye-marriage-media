<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Common data providers tailored for Bangladesh
     */
    private function getPackages()
    {
        return [
            [
                'id' => 'professional',
                'name' => 'Elite Professional',
                'badge' => 'BCS, Medical & Corporate Leaders',
                'description' => 'Exclusive matchmaking for top corporate CXOs, BCS Cadres, doctors, engineers, and IBA graduates.',
                'featured' => false,
                'benefits' => [
                    'Dedicated Senior Relationship Manager in Dhaka / Ctg',
                    'Educational & Income verification (Annual ৳30 Lakhs+)',
                    'Handpicked matches from verified aristocratic families',
                    'Direct coordination with counterpart family matchmakers',
                    'Confidential introductions with mutual profile unlock',
                    'Assistance with initial meeting at premier Dhaka venues'
                ]
            ],
            [
                'id' => 'business',
                'name' => 'Elite Business',
                'badge' => 'Most Preferred for Industrialists',
                'description' => 'Bespoke services for business owners, directors, and next-gen successors of prominent industrialist families.',
                'featured' => true,
                'benefits' => [
                    'Principal Relationship Manager with HNI expertise',
                    'In-person family visits in Gulshan, Banani, DOHS, or Khulshi',
                    'Net worth & business asset verification (৳10 Cr - ৳100 Cr+)',
                    'Curated shortlist across Pan-Bangladesh & Global NRBs',
                    'Confidential family meetings at 5-star hotels (Radisson / Westin)',
                    'Discreet family background & lineage (Bongsho) verification',
                    'Optional Shari\'ah-conscious / Deen-compatible matchmaking'
                ]
            ],
            [
                'id' => 'aristocrat',
                'name' => 'Elite Aristocrat',
                'badge' => 'Ultra High Net-Worth (UHNI)',
                'description' => 'Flagship concierge for top conglomerate dynasties, eminent landowners, and global NRB elites.',
                'featured' => false,
                'benefits' => [
                    'Managing Director / Board-level Private Matchmaker',
                    '100% Blind Matching (Strict Non-Disclosure Guarantee)',
                    'Worldwide scouting across London, New York, Toronto & Dubai',
                    'Bespoke high-profile introductions with zero online trace',
                    'Private jet / VIP hospitality coordination for family meetings',
                    'Direct principal-to-principal family council facilitation',
                    'Exclusive invitations to private matrimonial salons in Dhaka'
                ]
            ]
        ];
    }

    private function getStories()
    {
        return [
            [
                'names' => 'Nabila & Farhan Rahman',
                'titles' => 'Barrister (Lincoln\'s Inn) & RMG Conglomerate Director',
                'locations' => 'Gulshan-2, Dhaka & London',
                'image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
                'quote' => 'Biye Marriage Media handled our alliance with exceptional dignity and discretion. Finding a partner who understood both our business lineage and cultural values was effortless.',
                'year' => 'Married at Senakunj, Dhaka • Dec 2024'
            ],
            [
                'names' => 'Dr. Tazrian & Capt. Zarif Chowdhury',
                'titles' => 'Assistant Professor (DMC) & Bangladesh Army Officer',
                'locations' => 'DOHS Baridhara, Dhaka & Chattogram',
                'image' => 'https://images.unsplash.com/photo-1609151162377-794fa68b02f1?auto=format&fit=crop&w=800&q=80',
                'quote' => 'Both of our families value pedigree, education, and shared traditions. The in-home consultation by our Relationship Manager in Baridhara ensured complete peace of mind.',
                'year' => 'Married at Radisson Blu Water Garden • Jan 2025'
            ],
            [
                'names' => 'Sumaiya & Ahsanul Karim (NRB)',
                'titles' => 'Architect & AI Fintech Founder (Silicon Valley)',
                'locations' => 'Sylhet & San Francisco',
                'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
                'quote' => 'As an NRB family based between Sylhet and California, we wanted a bridge that connected modern ambition with deep roots. Biye Marriage Media was the perfect choice.',
                'year' => 'Married at Rose View Hotel, Sylhet • Nov 2024'
            ],
            [
                'names' => 'Samira & Dewan Arsalan',
                'titles' => 'IBA Graduate & 3rd-Gen Shipping Merchant Heir',
                'locations' => 'Khulshi, Chattogram & Dubai',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                'quote' => 'The absolute privacy was paramount for our family. No photos were made public without bilateral consent, and the matchmaking etiquette was exemplary.',
                'year' => 'Married at Radisson Blu Bay View, Ctg • Oct 2024'
            ]
        ];
    }

    private function getProfiles()
    {
        return [
            [
                'id' => 'BD-ELT-9041',
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
                'discreet' => true
            ],
            [
                'id' => 'BD-ELT-8120',
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
                'discreet' => true
            ],
            [
                'id' => 'BD-ELT-7319',
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
                'discreet' => false
            ],
            [
                'id' => 'BD-ELT-9552',
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
                'discreet' => true
            ],
            [
                'id' => 'BD-ELT-6410',
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
                'discreet' => false
            ],
            [
                'id' => 'BD-ELT-3814',
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
                'discreet' => true
            ]
        ];
    }

    private function getFaqs()
    {
        return [
            [
                'question' => 'How does Biye Marriage Media ensure complete confidentiality in Bangladesh?',
                'answer' => 'We practice strict blind matchmaking. In Bangladeshi high society, personal privacy is paramount. Your photos, full name, and family details are never accessible on any public database. Information is shared only as a private, curated brief after both families grant explicit bilateral consent.'
            ],
            [
                'question' => 'How does the Relationship Manager assist Bangladeshi families?',
                'answer' => 'Your assigned Senior Relationship Manager visits your residence in Dhaka (Gulshan, Banani, Baridhara, Dhanmondi, DOHS), Chattogram, or Sylhet. They take time to understand your cultural expectations, family background (Bongsho), lifestyle, and district preferences (Desher Bari), guiding both families with utmost etiquette.'
            ],
            [
                'question' => 'Who qualifies to join Biye Marriage Media?',
                'answer' => 'Membership is by qualification or invitation. We cater to high-net-worth business families, owners of RMG/industrial conglomerates, BCS Cadres, armed forces officer families, top medical and engineering specialists (BUET, DMC), IBA graduates, and prominent Non-Resident Bangladeshis (NRBs).'
            ],
            [
                'question' => 'Do you provide specialized matchmaking for Non-Resident Bangladeshis (NRBs)?',
                'answer' => 'Yes, our dedicated Global NRB Desks operate in London (UK), New York (USA), Toronto (Canada), Dubai (UAE), and Sydney (Australia), facilitating verified cross-border alliances between NRBs and premier families in Bangladesh.'
            ],
            [
                'question' => 'Can we request Shari\'ah-compliant / Deen-conscious matchmaking?',
                'answer' => 'Absolutely. We respect the diverse lifestyle and religious preferences of our clients. For families seeking Deen-conscious alliances, we follow strict modesty and Purdah protocols where family guardians (Walis) coordinate initial inquiries.'
            ],
            [
                'question' => 'What is the verification process for candidate profiles?',
                'answer' => 'All candidates undergo rigorous institutional checks including National Identity Card (NID) / Passport verification, educational credential verification (Board / University), professional position verification, and discrete family reputation checks.'
            ]
        ];
    }

    /**
     * View Actions
     */
    public function home()
    {
        return view('pages.home', [
            'packages' => $this->getPackages(),
            'stories' => $this->getStories(),
            'profiles' => array_slice($this->getProfiles(), 0, 4),
            'faqs' => $this->getFaqs()
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function packages()
    {
        return view('pages.packages', [
            'packages' => $this->getPackages()
        ]);
    }

    public function profiles(Request $request)
    {
        $profiles = $this->getProfiles();

        // Filtering
        if ($request->filled('gender')) {
            $profiles = array_filter($profiles, fn($p) => $p['gender'] === $request->gender);
        }
        if ($request->filled('category')) {
            $profiles = array_filter($profiles, fn($p) => str_contains(strtolower($p['category']), strtolower($request->category)));
        }
        if ($request->filled('desher_bari')) {
            $profiles = array_filter($profiles, fn($p) => str_contains(strtolower($p['desher_bari']), strtolower($request->desher_bari)));
        }

        return view('pages.profiles', [
            'profiles' => $profiles,
            'filters' => $request->all()
        ]);
    }

    public function stories()
    {
        return view('pages.stories', [
            'stories' => $this->getStories()
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitConsultation(Request $request)
    {
        $validated = $request->validate([
            'looking_for' => 'required|string',
            'profile_for' => 'required|string',
            'full_name' => 'required|string|max:100',
            'phone' => 'required|string|max:25',
            'email' => 'required|email|max:100',
            'city' => 'nullable|string|max:100',
            'desher_bari' => 'nullable|string|max:100',
            'annual_income' => 'nullable|string',
            'preferred_package' => 'nullable|string'
        ]);

        return back()->with('success_modal', true)->with('consultation_name', $validated['full_name']);
    }
}
