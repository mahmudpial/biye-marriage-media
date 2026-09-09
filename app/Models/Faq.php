<?php

namespace App\Models;

use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    /** @use HasFactory<FaqFactory> */
    use HasFactory;

    public const CATEGORIES = [
        'Confidentiality' => 'Confidentiality & Discretion',
        'Verification' => 'Verification & Background Checks',
        'NRB Matchmaking' => 'NRB & Overseas Desks',
        'Membership & Fees' => 'Membership, Tiers & Fees',
        'Values & Shariah' => 'Islamic Values & Shariah',
        'General' => 'General Process & Service',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order FAQs by sort_order ascending, then id ascending.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, ?string $category)
    {
        if (! empty($category)) {
            return $query->where('category', $category);
        }

        return $query;
    }
}
