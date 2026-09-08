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
     * Scope for featured profiles.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
