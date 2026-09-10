<?php

namespace App\Models;

use Database\Factories\ShortlistFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shortlist extends Model
{
    /** @use HasFactory<ShortlistFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'candidate_profile_id',
    ];

    /**
     * User who shortlisted the candidate.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Candidate profile bookmarked.
     */
    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
