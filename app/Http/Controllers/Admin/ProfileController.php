<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the candidate profiles.
     */
    public function index(Request $request): View
    {
        $query = CandidateProfile::query();

        // Search filter (Code, Profession, Desher Bari, Location, Education)
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('profile_code', 'like', "%{$search}%")
                    ->orWhere('profession', 'like', "%{$search}%")
                    ->orWhere('desher_bari', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('education', 'like', "%{$search}%");
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Status filter
        if ($request->filled('status')) {
            match ($request->input('status')) {
                'active' => $query->where('is_active', true),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->where('is_featured', true),
                'discreet' => $query->where('is_discreet', true),
                default => null,
            };
        }

        $profiles = $query->latest('id')->paginate(10)->withQueryString();

        $stats = [
            'total' => CandidateProfile::count(),
            'active' => CandidateProfile::where('is_active', true)->count(),
            'brides' => CandidateProfile::where('gender', 'female')->count(),
            'grooms' => CandidateProfile::where('gender', 'male')->count(),
            'featured' => CandidateProfile::where('is_featured', true)->count(),
        ];

        return view('admin.profiles.index', [
            'profiles' => $profiles,
            'stats' => $stats,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new candidate profile.
     */
    public function create(): View
    {
        return view('admin.profiles.form', [
            'profile' => new CandidateProfile([
                'is_active' => true,
                'is_discreet' => true,
                'is_featured' => false,
                'religion' => 'Islam (Sunni)',
                'category' => 'Elite Professional',
                'gender' => 'female',
            ]),
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created candidate profile in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validateProfile($request);

            if (empty($validated['profile_code'])) {
                $validated['profile_code'] = 'BD-ELT-'.rand(1000, 9999);
            }

            $uploadedImage = $this->handleImageUpload($request);
            if ($uploadedImage !== null && $uploadedImage !== false) {
                $validated['image'] = $uploadedImage;
            }

            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['is_discreet'] = $request->boolean('is_discreet', true);
            $validated['is_featured'] = $request->boolean('is_featured', false);

            unset($validated['image_file'], $validated['image_url']);

            $profile = CandidateProfile::create($validated);

            return redirect()->route('admin.profiles.index')
                ->with('success', "Candidate profile #{$profile->profile_code} has been successfully created.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create candidate profile: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to create profile: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified candidate profile.
     */
    public function edit(CandidateProfile $profile): View
    {
        return view('admin.profiles.form', [
            'profile' => $profile,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified candidate profile in storage.
     */
    public function update(Request $request, CandidateProfile $profile): RedirectResponse
    {
        try {
            $validated = $this->validateProfile($request, $profile->id);

            $newImage = $this->handleImageUpload($request, $profile->image);
            if ($newImage !== null && $newImage !== false) {
                $validated['image'] = $newImage;
            }

            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_discreet'] = $request->boolean('is_discreet');
            $validated['is_featured'] = $request->boolean('is_featured');

            unset($validated['image_file'], $validated['image_url']);

            $profile->update($validated);

            return redirect()->route('admin.profiles.index')
                ->with('success', "Candidate profile #{$profile->profile_code} has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update candidate profile #{$profile->profile_code}: ".$e->getMessage(), [
                'exception' => $e,
                'profile_id' => $profile->id,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to save profile changes: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified candidate profile from storage.
     */
    public function destroy(CandidateProfile $profile): RedirectResponse
    {
        try {
            $code = $profile->profile_code;

            if (! empty($profile->image) && ! str_starts_with($profile->image, 'http')) {
                try {
                    Storage::disk('public')->delete($profile->image);
                } catch (\Throwable $e) {
                    Log::warning("Could not delete image file for profile #{$code}: ".$e->getMessage());
                }
            }

            $profile->delete();

            return redirect()->route('admin.profiles.index')
                ->with('success', "Candidate profile #{$code} was deleted successfully.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete candidate profile #{$profile->profile_code}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete profile: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the active/inactive state of a candidate profile.
     */
    public function toggleActive(CandidateProfile $profile): RedirectResponse
    {
        try {
            $profile->is_active = ! $profile->is_active;
            $profile->save();

            $status = $profile->is_active ? 'activated' : 'deactivated';

            return back()->with('success', "Profile #{$profile->profile_code} has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle active state for profile #{$profile->profile_code}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update status: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle featured state of a candidate profile.
     */
    public function toggleFeatured(CandidateProfile $profile): RedirectResponse
    {
        try {
            $profile->is_featured = ! $profile->is_featured;
            $profile->save();

            $status = $profile->is_featured ? 'marked as featured' : 'unmarked from featured';

            return back()->with('success', "Profile #{$profile->profile_code} has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle featured state for profile #{$profile->profile_code}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update featured state: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Validate candidate profile input.
     *
     * @return array<string, mixed>
     */
    protected function validateProfile(Request $request, ?int $profileId = null): array
    {
        return $request->validate([
            'profile_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('candidate_profiles', 'profile_code')->ignore($profileId),
            ],
            'gender' => ['required', 'string', 'in:male,female'],
            'age' => ['required', 'integer', 'min:18', 'max:99'],
            'height' => ['required', 'string', 'max:20'],
            'religion' => ['required', 'string', 'max:60'],
            'desher_bari' => ['required', 'string', 'max:100'],
            'education' => ['required', 'string', 'max:255'],
            'profession' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'income' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:60'],
            'family' => ['required', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'is_discreet' => ['nullable'],
            'is_featured' => ['nullable'],
            'is_active' => ['nullable'],
        ]);
    }

    /**
     * Handle photo upload from file or fallback to URL.
     */
    protected function handleImageUpload(Request $request, ?string $currentImage = null): ?string
    {
        if ($request->hasFile('image_file')) {
            if ($currentImage && ! str_starts_with($currentImage, 'http')) {
                try {
                    Storage::disk('public')->delete($currentImage);
                } catch (\Throwable $e) {
                    Log::warning('Failed deleting old candidate image: '.$e->getMessage());
                }
            }

            try {
                $storedPath = $request->file('image_file')->store('profiles', 'public');
                if ($storedPath) {
                    return $storedPath;
                }
            } catch (\Throwable $e) {
                Log::error('Candidate image upload failed: '.$e->getMessage(), [
                    'exception' => $e,
                ]);
            }
        }

        if ($request->filled('image_url')) {
            return $request->input('image_url');
        }

        return $currentImage;
    }
}
