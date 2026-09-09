<?php

namespace Database\Seeders;

use App\Models\SuccessStory;
use Illuminate\Database\Seeder;

class SuccessStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = [
            [
                'names' => 'Nabila & Farhan Rahman',
                'titles' => 'Barrister (Lincoln\'s Inn) & RMG Conglomerate Director',
                'locations' => 'Gulshan-2, Dhaka & London',
                'image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
                'quote' => 'Biye Marriage Media handled our alliance with exceptional dignity and discretion. Finding a partner who understood both our business lineage and cultural values was effortless.',
                'year' => 'Married at Senakunj, Dhaka • Dec 2024',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'names' => 'Dr. Tazrian & Capt. Zarif Chowdhury',
                'titles' => 'Assistant Professor (DMC) & Bangladesh Army Officer',
                'locations' => 'DOHS Baridhara, Dhaka & Chattogram',
                'image' => 'https://images.unsplash.com/photo-1609151162377-794fa68b02f1?auto=format&fit=crop&w=800&q=80',
                'quote' => 'Both of our families value pedigree, education, and shared traditions. The in-home consultation by our Relationship Manager in Baridhara ensured complete peace of mind.',
                'year' => 'Married at Radisson Blu Water Garden • Jan 2025',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'names' => 'Sumaiya & Ahsanul Karim (NRB)',
                'titles' => 'Architect & AI Fintech Founder (Silicon Valley)',
                'locations' => 'Sylhet & San Francisco',
                'image' => 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
                'quote' => 'As an NRB family based between Sylhet and California, we wanted a bridge that connected modern ambition with deep roots. Biye Marriage Media was the perfect choice.',
                'year' => 'Married at Rose View Hotel, Sylhet • Nov 2024',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'names' => 'Samira & Dewan Arsalan',
                'titles' => 'IBA Graduate & 3rd-Gen Shipping Merchant Heir',
                'locations' => 'Khulshi, Chattogram & Dubai',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                'quote' => 'The absolute privacy was paramount for our family. No photos were made public without bilateral consent, and the matchmaking etiquette was exemplary.',
                'year' => 'Married at Radisson Blu Bay View, Ctg • Oct 2024',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($stories as $storyData) {
            SuccessStory::updateOrCreate(
                ['names' => $storyData['names']],
                $storyData
            );
        }
    }
}
