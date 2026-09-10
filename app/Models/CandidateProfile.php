<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'profile_code',
        'gender',
        'age',
        'height',
        'religion',
        'desher_bari',
        'education',
        'profession',
        'location',
        'income',
        'category',
        'family',
        'image',
        'is_discreet',
        'is_featured',
        'is_active',
        'approval_status',
        'admin_notes',
        'completion_score',
        'pref_age_min',
        'pref_age_max',
        'pref_height_min',
        'pref_height_max',
        'pref_education',
        'pref_profession',
        'pref_desher_bari',
        'pref_marital_status',
        'pref_religion',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'is_discreet' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'completion_score' => 'integer',
            'pref_age_min' => 'integer',
            'pref_age_max' => 'integer',
        ];
    }

    /**
     * Accessor for 'discreet' to support legacy frontend views ($profile['discreet']).
     */
    public function getDiscreetAttribute(): bool
    {
        return (bool) ($this->attributes['is_discreet'] ?? true);
    }

    /**
     * Resolve image URL whether it is a local storage upload or an external CDN URL.
     */
    public function getResolvedImageAttribute(): string
    {
        if (empty($this->image)) {
            return asset('site-logo/marriage-logo.jpeg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/'.$this->image);
    }

    /**
     * Scope for active profiles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for approved profiles for public display.
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Scope for profiles pending review.
     */
    public function scopeUnderReview($query)
    {
        return $query->where('approval_status', 'under_review');
    }

    /**
     * Scope for featured profiles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * The client user who owns this profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Proposals received by this profile.
     */
    public function receivedProposals()
    {
        return $this->hasMany(Proposal::class, 'receiver_profile_id');
    }

    /**
     * Proposals sent on behalf of this profile.
     */
    public function sentProposals()
    {
        return $this->hasMany(Proposal::class, 'sender_profile_id');
    }

    /**
     * Shortlist entries for this profile.
     */
    public function shortlistedBy()
    {
        return $this->hasMany(Shortlist::class, 'candidate_profile_id');
    }
}
