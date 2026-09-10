<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'is_admin',
    'user_type',
    'profile_for',
    'guardian_name',
    'assigned_staff_id',
    'verification_status',
    'verified_at',
    'status',
    'suspension_reason',
    'role',
    'designation',
    'phone',
    'is_active',
    'last_login_at',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const TYPE_STAFF = 'staff';

    public const TYPE_CLIENT = 'client';

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

    public const VERIFICATION_PENDING = 'pending';

    public const VERIFICATION_VERIFIED = 'verified';

    public const VERIFICATION_REJECTED = 'rejected';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_SUSPENDED = 'suspended';

    public const STATUS_PENDING = 'pending';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->is_admin || $this->user_type === self::TYPE_STAFF;
    }

    /**
     * Check if user is a matrimony client / member.
     */
    public function isClient(): bool
    {
        return ! $this->is_admin && $this->user_type === self::TYPE_CLIENT;
    }

    /**
     * Check if user is a super administrator.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN || $this->email === 'admin@biyemedia.com';
    }

    /**
     * Check if user biodata is verified.
     */
    public function isVerified(): bool
    {
        return $this->verification_status === self::VERIFICATION_VERIFIED;
    }

    /**
     * Check if client account is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Get human-readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        if ($this->isClient()) {
            return 'Elite Member ('.ucfirst($this->profile_for ?? 'Self').')';
        }

        return self::ROLES[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role ?? 'matchmaker'));
    }

    /**
     * The candidate profile owned by this client.
     */
    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    /**
     * Staff member assigned to this client.
     */
    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    /**
     * Clients assigned to this staff member.
     */
    public function assignedClients()
    {
        return $this->hasMany(User::class, 'assigned_staff_id');
    }

    /**
     * Subscription history for this user.
     */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Active subscription for this user.
     */
    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')->latestOfMany();
    }

    /**
     * Proposals sent by this user.
     */
    public function sentProposals()
    {
        return $this->hasMany(Proposal::class, 'sender_user_id');
    }

    /**
     * Shortlisted candidate profiles by this user.
     */
    public function shortlists()
    {
        return $this->hasMany(Shortlist::class);
    }

    /**
     * Verification documents uploaded by this user.
     */
    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', '!=', self::STATUS_SUSPENDED);
    }

    /**
     * Scope to query only clients.
     */
    public function scopeClients($query)
    {
        return $query->where('user_type', self::TYPE_CLIENT)->where('is_admin', false);
    }

    /**
     * Scope to query only staff members.
     */
    public function scopeStaffMembers($query)
    {
        return $query->where(function ($q) {
            $q->where('is_admin', true)
                ->orWhere('user_type', self::TYPE_STAFF);
        });
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
