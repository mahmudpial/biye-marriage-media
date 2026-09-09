<?php

namespace App\Models;

use Database\Factories\ConsultationInquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationInquiry extends Model
{
    /** @use HasFactory<ConsultationInquiryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'inquiry_code',
        'looking_for',
        'profile_for',
        'full_name',
        'phone',
        'email',
        'city',
        'desher_bari',
        'preferred_package',
        'annual_income',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Generate a unique formatted inquiry tracking code (e.g. INQ-1045).
     */
    public static function generateUniqueCode(): string
    {
        $lastId = static::max('id') ?? 0;
        $candidateCode = 'INQ-'.(1000 + $lastId + 1);

        while (static::where('inquiry_code', $candidateCode)->exists()) {
            $lastId++;
            $candidateCode = 'INQ-'.(1000 + $lastId + 1);
        }

        return $candidateCode;
    }

    /**
     * Scope for pending review leads.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Pending Review');
    }

    /**
     * Scope for specific status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for recent inquiries.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    /**
     * Sanitized international phone number for WhatsApp link.
     */
    public function getCleanPhoneAttribute(): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', (string) $this->phone);
        if (str_starts_with($cleaned, '01') && strlen($cleaned) === 11) {
            return '88'.$cleaned;
        }

        return $cleaned;
    }

    /**
     * Backward-compatible name accessor for dashboard table.
     */
    public function getNameAttribute(): string
    {
        return $this->full_name ?? '';
    }

    /**
     * Backward-compatible location accessor for dashboard table.
     */
    public function getLocationAttribute(): string
    {
        return $this->city ?: 'Pan-Bangladesh';
    }

    /**
     * Backward-compatible package accessor for dashboard table.
     */
    public function getPackageAttribute(): string
    {
        return $this->preferred_package ?: 'Standard Tier';
    }
}
