<?php

namespace App\Models;

use Database\Factories\ProposalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    /** @use HasFactory<ProposalFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_DECLINED = 'declined';

    public const STATUS_UNDER_REVIEW = 'under_review';

    public const STATUS_CONTACT_SHARED = 'contact_shared';

    protected $fillable = [
        'sender_user_id',
        'sender_profile_id',
        'receiver_profile_id',
        'status',
        'is_matchmaker_suggested',
        'assigned_staff_id',
        'sender_message',
        'matchmaker_internal_notes',
        'responded_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_matchmaker_suggested' => 'boolean',
            'responded_at' => 'datetime',
        ];
    }

    /**
     * User who initiated the proposal.
     */
    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * Candidate profile of the sender.
     */
    public function senderProfile()
    {
        return $this->belongsTo(CandidateProfile::class, 'sender_profile_id');
    }

    /**
     * Candidate profile of the receiver.
     */
    public function receiverProfile()
    {
        return $this->belongsTo(CandidateProfile::class, 'receiver_profile_id');
    }

    /**
     * Matchmaker staff assigned to oversee this proposal.
     */
    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }
}
