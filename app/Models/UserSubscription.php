<?php

namespace App\Models;

use Database\Factories\UserSubscriptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    /** @use HasFactory<UserSubscriptionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'package_name',
        'price_paid',
        'proposals_quota',
        'proposals_used',
        'contact_views_quota',
        'contact_views_used',
        'status',
        'starts_at',
        'expires_at',
        'payment_method',
        'transaction_id',
        'admin_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'price_paid' => 'decimal:2',
            'proposals_quota' => 'integer',
            'proposals_used' => 'integer',
            'contact_views_quota' => 'integer',
            'contact_views_used' => 'integer',
        ];
    }

    /**
     * Client user associated with subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Plan package associated with subscription.
     */
    public function package()
    {
        return $this->belongsTo(MembershipPackage::class, 'package_id');
    }

    /**
     * Count of remaining proposals.
     */
    public function remainingProposals(): int
    {
        return max(0, $this->proposals_quota - $this->proposals_used);
    }

    /**
     * Check if user has available proposals to send.
     */
    public function hasProposals(): bool
    {
        return $this->status === 'active' && ! $this->isExpired() && $this->remainingProposals() > 0;
    }

    /**
     * Count of remaining contact views.
     */
    public function remainingContactViews(): int
    {
        return max(0, $this->contact_views_quota - $this->contact_views_used);
    }

    /**
     * Check if subscription has expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
