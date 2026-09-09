<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of membership packages.
     */
    public function index(Request $request): View
    {
        $query = MembershipPackage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === '1');
        }

        $packages = $query->ordered()->paginate(10)->withQueryString();

        $allPackages = MembershipPackage::all();
        $totalBenefits = $allPackages->sum(function ($pkg) {
            return is_array($pkg->benefits) ? count($pkg->benefits) : 0;
        });

        $stats = [
            'total' => $allPackages->count(),
            'active' => $allPackages->where('is_active', true)->count(),
            'featured' => $allPackages->where('featured', true)->count(),
            'total_benefits' => $totalBenefits,
        ];

        return view('admin.packages.index', [
            'packages' => $packages,
            'stats' => $stats,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new membership package.
     */
    public function create(): View
    {
        $nextOrder = (MembershipPackage::max('sort_order') ?? 0) + 1;

        return view('admin.packages.form', [
            'package' => new MembershipPackage([
                'is_active' => true,
                'featured' => false,
                'sort_order' => $nextOrder,
                'benefits' => [],
            ]),
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created membership package in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validatePackage($request);

            $package = MembershipPackage::create($validated);

            return redirect()->route('admin.packages.index')
                ->with('success', "Membership package '{$package->name}' has been created successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create membership package: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to create membership package: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified membership package.
     */
    public function edit(MembershipPackage $package): View
    {
        return view('admin.packages.form', [
            'package' => $package,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified membership package in storage.
     */
    public function update(Request $request, MembershipPackage $package): RedirectResponse
    {
        try {
            $validated = $this->validatePackage($request, $package->id);

            $package->update($validated);

            return redirect()->route('admin.packages.index')
                ->with('success', "Membership package '{$package->name}' has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update membership package '{$package->name}': ".$e->getMessage(), [
                'exception' => $e,
                'package_id' => $package->id,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to update membership package: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified membership package from storage.
     */
    public function destroy(MembershipPackage $package): RedirectResponse
    {
        try {
            $name = $package->name;
            $package->delete();

            return redirect()->route('admin.packages.index')
                ->with('success', "Membership package '{$name}' was deleted successfully.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete membership package '{$package->name}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete package: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the active status of the specified package.
     */
    public function toggleActive(MembershipPackage $package): RedirectResponse
    {
        try {
            $package->is_active = ! $package->is_active;
            $package->save();

            $status = $package->is_active ? 'activated' : 'deactivated';

            return back()->with('success', "Package '{$package->name}' has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle active state for package '{$package->name}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update status: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the featured status of the specified package.
     */
    public function toggleFeatured(MembershipPackage $package): RedirectResponse
    {
        try {
            $package->featured = ! $package->featured;
            $package->save();

            $status = $package->featured ? 'marked as Most Preferred' : 'unmarked from Most Preferred';

            return back()->with('success', "Package '{$package->name}' has been {$status}.");
        } catch (\Throwable $e) {
            Log::error("Failed to toggle featured status for package '{$package->name}': ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update featured status: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Validate package input data and format benefits.
     *
     * @return array<string, mixed>
     */
    private function validatePackage(Request $request, ?int $packageId = null): array
    {
        $slugRule = 'nullable|string|max:100|unique:membership_packages,slug';
        if ($packageId !== null) {
            $slugRule .= ",{$packageId}";
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => $slugRule,
            'badge' => 'nullable|string|max:120',
            'price' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'benefits_text' => 'required|string',
            'sort_order' => 'nullable|integer',
            'featured' => 'nullable',
            'is_active' => 'nullable',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            // Ensure generated slug uniqueness if conflict exists
            $count = MembershipPackage::where('slug', $validated['slug'])
                ->when($packageId, fn ($q) => $q->where('id', '!=', $packageId))
                ->count();
            if ($count > 0) {
                $validated['slug'] .= '-'.time();
            }
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Parse benefits textarea lines into clean array
        $lines = explode("\n", str_replace("\r", '', $validated['benefits_text']));
        $benefits = array_values(array_filter(array_map('trim', $lines), fn ($line) => $line !== ''));

        if (empty($benefits)) {
            throw ValidationException::withMessages([
                'benefits_text' => 'Please provide at least one included matchmaking privilege or benefit.',
            ]);
        }

        $validated['benefits'] = $benefits;
        unset($validated['benefits_text']);

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['featured'] = $request->boolean('featured');
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
