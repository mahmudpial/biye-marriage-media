<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StoryController extends Controller
{
    /**
     * Display a listing of success stories.
     */
    public function index(Request $request): View
    {
        $query = SuccessStory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('names', 'like', "%{$search}%")
                    ->orWhere('titles', 'like', "%{$search}%")
                    ->orWhere('locations', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%")
                    ->orWhere('quote', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        $stories = $query->ordered()->paginate(10)->withQueryString();

        $allStories = SuccessStory::all();

        $stats = [
            'total' => $allStories->count(),
            'active' => $allStories->where('is_active', true)->count(),
            'featured' => $allStories->where('is_featured', true)->count(),
        ];

        return view('admin.stories.index', [
            'stories' => $stories,
            'stats' => $stats,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new success story.
     */
    public function create(): View
    {
        $nextOrder = (SuccessStory::max('sort_order') ?? 0) + 1;

        return view('admin.stories.form', [
            'story' => new SuccessStory([
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => $nextOrder,
            ]),
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created success story in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validateStory($request);

            $imagePath = $this->handleImageUpload($request);
            if ($imagePath !== null && $imagePath !== false) {
                $validated['image'] = $imagePath;
            }

            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');
            $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

            unset($validated['image_file'], $validated['image_url']);

            $story = SuccessStory::create($validated);

            return redirect()->route('admin.stories.index')
                ->with('success', "Success story '{$story->names}' has been added successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create success story: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to create success story: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified success story.
     */
    public function edit(SuccessStory $story): View
    {
        return view('admin.stories.form', [
            'story' => $story,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified success story in storage.
     */
    public function update(Request $request, SuccessStory $story): RedirectResponse
    {
        try {
            $validated = $this->validateStory($request, $story->id);

            $currentRawImage = $story->getRawOriginal('image');
            $newImage = $this->handleImageUpload($request, $currentRawImage);
            if ($newImage !== null && $newImage !== false) {
                $validated['image'] = $newImage;
            }

            $validated['is_active'] = $request->boolean('is_active');
            $validated['is_featured'] = $request->boolean('is_featured');
            $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

            unset($validated['image_file'], $validated['image_url']);

            $story->update($validated);

            return redirect()->route('admin.stories.index')
                ->with('success', "Success story '{$story->names}' has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update success story '{$story->names}': ".$e->getMessage(), [
                'exception' => $e,
                'story_id' => $story->id,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to update success story: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified success story from storage.
     */
    public function destroy(SuccessStory $story): RedirectResponse
    {
        try {
            $names = $story->names;
            $rawImage = $story->getRawOriginal('image');

            if (! empty($rawImage) && ! str_starts_with($rawImage, 'http')) {
                try {
                    Storage::disk('public')->delete($rawImage);
                } catch (\Throwable $e) {
                    Log::warning("Could not delete image file for story '{$names}': ".$e->getMessage());
                }
            }

            $story->delete();

            return redirect()->route('admin.stories.index')
                ->with('success', "Success story '{$names}' was deleted successfully.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete success story '{$story->names}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete success story: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the active/inactive state of a success story.
     */
    public function toggleActive(SuccessStory $story): RedirectResponse
    {
        try {
            $story->is_active = ! $story->is_active;
            $story->save();

            $status = $story->is_active ? 'activated and published' : 'deactivated and unpublished';

            return back()->with('success', "Success story '{$story->names}' has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle active state for story '{$story->names}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update story status: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the featured state of a success story.
     */
    public function toggleFeatured(SuccessStory $story): RedirectResponse
    {
        try {
            $story->is_featured = ! $story->is_featured;
            $story->save();

            $status = $story->is_featured ? 'featured on homepage' : 'removed from homepage featured list';

            return back()->with('success', "Success story '{$story->names}' has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle featured state for story '{$story->names}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update story featured state: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Validate success story input.
     *
     * @return array<string, mixed>
     */
    protected function validateStory(Request $request, ?int $storyId = null): array
    {
        return $request->validate([
            'names' => ['required', 'string', 'max:255'],
            'titles' => ['required', 'string', 'max:255'],
            'locations' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'url', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Handle local file upload or remote CDN image URL.
     */
    protected function handleImageUpload(Request $request, ?string $currentImage = null): ?string
    {
        if ($request->hasFile('image_file')) {
            if ($currentImage && ! str_starts_with($currentImage, 'http')) {
                try {
                    Storage::disk('public')->delete($currentImage);
                } catch (\Throwable $e) {
                    Log::warning('Failed deleting old story image: '.$e->getMessage());
                }
            }

            try {
                $storedPath = $request->file('image_file')->store('stories', 'public');
                if ($storedPath) {
                    return $storedPath;
                }
            } catch (\Throwable $e) {
                Log::error('Story image upload failed: '.$e->getMessage(), [
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
