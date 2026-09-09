<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'role', 'designation', 'phone', 'is_active', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_SENIOR_MATCHMAKER = 'senior_matchmaker';

    public const ROLE_RELATIONSHIP_MANAGER = 'relationship_manager';

    public const ROLE_PROFILE_AUDITOR = 'profile_auditor';

    public const ROLES = [
        self::ROLE_SUPER_ADMIN => 'Super Administrator',
        self::ROLE_SENIOR_MATCHMAKER => 'Senior Matchmaker',
        self::ROLE_RELATIONSHIP_MANAGER => 'Relationship Manager',
        self::ROLE_PROFILE_AUDITOR => 'Profile Auditor',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is a super administrator.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN || $this->email === 'admin@biyemedia.com';
    }

    /**
     * Get human-readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role ?? 'matchmaker'));
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by role.
     */
    public function scopeRole($query, ?string $role)
    {
        if (! empty($role)) {
            return $query->where('role', $role);
        }

        return $query;
    }
}
