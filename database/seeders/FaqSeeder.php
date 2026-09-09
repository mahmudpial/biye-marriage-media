<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How does Biye Marriage Media ensure complete confidentiality in Bangladesh?',
                'answer' => 'We practice strict blind matchmaking. In Bangladeshi high society, personal privacy is paramount. Your photos, full name, and family details are never accessible on any public database. Information is shared only as a private, curated brief after both families grant explicit bilateral consent.',
                'category' => 'Confidentiality',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'How does the Relationship Manager assist Bangladeshi families?',
                'answer' => 'Your assigned Senior Relationship Manager visits your residence in Dhaka (Gulshan, Banani, Baridhara, Dhanmondi, DOHS), Chattogram, or Sylhet. They take time to understand your cultural expectations, family background (Bongsho), lifestyle, and district preferences (Desher Bari), guiding both families with utmost etiquette.',
                'category' => 'General',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Who qualifies to join Biye Marriage Media?',
                'answer' => 'Membership is by qualification or invitation. We cater to high-net-worth business families, owners of RMG/industrial conglomerates, BCS Cadres, armed forces officer families, top medical and engineering specialists (BUET, DMC), IBA graduates, and prominent Non-Resident Bangladeshis (NRBs).',
                'category' => 'Membership & Fees',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Do you provide specialized matchmaking for Non-Resident Bangladeshis (NRBs)?',
                'answer' => 'Yes, our dedicated Global NRB Desks operate in London (UK), New York (USA), Toronto (Canada), Dubai (UAE), and Sydney (Australia), facilitating verified cross-border alliances between NRBs and premier families in Bangladesh.',
                'category' => 'NRB Matchmaking',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Can we request Shari\'ah-compliant / Deen-conscious matchmaking?',
                'answer' => 'Absolutely. We respect the diverse lifestyle and religious preferences of our clients. For families seeking Deen-conscious alliances, we follow strict modesty and Purdah protocols where family guardians (Walis) coordinate initial inquiries.',
                'category' => 'Values & Shariah',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'What is the verification process for candidate profiles?',
                'answer' => 'All candidates undergo rigorous institutional checks including National Identity Card (NID) / Passport verification, educational credential verification (Board / University), professional position verification, and discrete family reputation checks.',
                'category' => 'Verification',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
