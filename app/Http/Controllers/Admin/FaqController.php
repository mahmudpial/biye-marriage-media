<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display a listing of FAQs.
     */
    public function index(Request $request): View
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $faqs = $query->ordered()->paginate(10)->withQueryString();

        $allFaqs = Faq::all();

        $stats = [
            'total' => $allFaqs->count(),
            'active' => $allFaqs->where('is_active', true)->count(),
            'inactive' => $allFaqs->where('is_active', false)->count(),
            'categories_count' => $allFaqs->pluck('category')->unique()->filter()->count(),
        ];

        return view('admin.faqs.index', [
            'faqs' => $faqs,
            'stats' => $stats,
            'categories' => Faq::CATEGORIES,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create(): View
    {
        $nextOrder = (Faq::max('sort_order') ?? 0) + 1;

        return view('admin.faqs.form', [
            'faq' => new Faq([
                'is_active' => true,
                'sort_order' => $nextOrder,
                'category' => 'General',
            ]),
            'categories' => Faq::CATEGORIES,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validateFaq($request);
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['sort_order'] = (int) ($validated['sort_order'] ?? ((Faq::max('sort_order') ?? 0) + 1));

            $faq = Faq::create($validated);

            return redirect()->route('admin.faqs.index')
                ->with('success', "FAQ '{$faq->question}' has been published successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create FAQ: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to create FAQ: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', [
            'faq' => $faq,
            'categories' => Faq::CATEGORIES,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        try {
            $validated = $this->validateFaq($request);
            $validated['is_active'] = $request->boolean('is_active');
            $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

            $faq->update($validated);

            return redirect()->route('admin.faqs.index')
                ->with('success', "FAQ '{$faq->question}' has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update FAQ #{$faq->id}: ".$e->getMessage(), [
                'exception' => $e,
                'faq_id' => $faq->id,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to update FAQ: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        try {
            $question = $faq->question;
            $faq->delete();

            return redirect()->route('admin.faqs.index')
                ->with('success', "FAQ '{$question}' has been deleted.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete FAQ #{$faq->id}: ".$e->getMessage(), [
                'exception' => $e,
                'faq_id' => $faq->id,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete FAQ: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the active status of an FAQ.
     */
    public function toggleActive(Request $request, Faq $faq): RedirectResponse|JsonResponse
    {
        $faq->update([
            'is_active' => ! $faq->is_active,
        ]);

        $statusText = $faq->is_active ? 'published' : 'hidden';
        $message = "FAQ is now {$statusText}.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $faq->is_active,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.faqs.index')->with('success', $message);
    }

    /**
     * Validate FAQ request input.
     *
     * @return array<string, mixed>
     */
    private function validateFaq(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable'],
        ], [
            'question.required' => 'The question field is required.',
            'answer.required' => 'The answer field is required.',
            'category.required' => 'Please select or enter a category.',
        ]);
    }
}
