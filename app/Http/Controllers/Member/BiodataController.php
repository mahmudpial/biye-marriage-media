<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BiodataController extends Controller
{
    /**
     * Show the member biodata editor.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;

        if (! $candidateProfile) {
            $candidateProfile = CandidateProfile::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'profile_code' => 'BD-ELT-'.random_int(20000, 99999),
                'gender' => 'female',
                'age' => 26,
                'height' => "5'4\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Dhaka',
                'education' => 'Bachelor / Masters',
                'profession' => 'Executive',
                'location' => 'Dhaka, Bangladesh',
                'income' => 'Confidential',
                'family' => 'Reputed family details will be provided.',
                'approval_status' => 'draft',
                'completion_score' => 40,
                'is_active' => true,
            ]);
        }

        return view('member.biodata', compact('user', 'candidateProfile'));
    }

    /**
     * Save and update member biodata details.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        $validated = $request->validate([
            'full_name' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'string', 'in:male,female'],
            'age' => ['required', 'integer', 'min:18', 'max:75'],
            'height' => ['required', 'string', 'max:20'],
            'religion' => ['required', 'string', 'max:60'],
            'desher_bari' => ['required', 'string', 'max:100'],
            'education' => ['required', 'string', 'max:255'],
            'profession' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'income' => ['required', 'string', 'max:100'],
            'family' => ['required', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_discreet' => ['nullable', 'boolean'],

            // Partner Preferences
            'pref_age_min' => ['nullable', 'integer', 'min:18', 'max:75'],
            'pref_age_max' => ['nullable', 'integer', 'min:18', 'max:75'],
            'pref_height_min' => ['nullable', 'string', 'max:20'],
            'pref_height_max' => ['nullable', 'string', 'max:20'],
            'pref_education' => ['nullable', 'string', 'max:100'],
            'pref_profession' => ['nullable', 'string', 'max:100'],
            'pref_desher_bari' => ['nullable', 'string', 'max:100'],
            'pref_marital_status' => ['nullable', 'string', 'max:50'],
            'pref_religion' => ['nullable', 'string', 'max:60'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old local image if exists
            if ($profile->image && ! str_starts_with($profile->image, 'http')) {
                Storage::disk('public')->delete($profile->image);
            }
            $imagePath = $request->file('image')->store('candidate-profiles', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_discreet'] = $request->boolean('is_discreet');

        // Calculate completion score
        $score = 20; // Base score for account
        if (! empty($validated['education'])) {
            $score += 15;
        }
        if (! empty($validated['profession'])) {
            $score += 15;
        }
        if (! empty($validated['family']) && strlen($validated['family']) > 20) {
            $score += 20;
        }
        if (! empty($validated['desher_bari'])) {
            $score += 10;
        }
        if (! empty($profile->image) || ! empty($validated['image'])) {
            $score += 10;
        }
        if (! empty($validated['pref_desher_bari']) || ! empty($validated['pref_profession'])) {
            $score += 10;
        }
        $validated['completion_score'] = min(100, $score);

        // Put under review if it was draft or updated
        if ($profile->approval_status === 'draft') {
            $validated['approval_status'] = 'under_review';
        }

        $profile->update($validated);

        return back()->with('success', 'আপনার বায়োডাটা সফলভাবে সংরক্ষণ করা হয়েছে। ম্যাচমেকার টিম প্রয়োজনীয় তথ্য অডিট করে সার্বিক সহায়তা করবে।');
    }

    /**
     * Toggle discreet photo blur privacy mode.
     */
    public function toggleDiscreet(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $profile = $user->candidateProfile;

        if ($profile) {
            $profile->update(['is_discreet' => ! $profile->is_discreet]);
            $msg = $profile->is_discreet
                ? 'গোপনীয়তা সুরক্ষা চালু করা হয়েছে। আপনার ছবি শুধুমাত্র অনুমতিপ্রাপ্ত ম্যাচমেকার ও অনুমোদিত প্রস্তাবনায় দৃশ্যমান হবে।'
                : 'গোপনীয়তা সুরক্ষা শিথিল করা হয়েছে। আপনার ছবি অন্যান্য মেম্বারদের কাছে স্পষ্ট দেখা যাবে।';

            return back()->with('info', $msg);
        }

        return back();
    }
}
