<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InquiryController extends Controller
{
    /**
     * Display a listing of VIP consultation inquiries.
     */
    public function index(Request $request): View
    {
        $query = ConsultationInquiry::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('inquiry_code', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('desher_bari', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('package')) {
            $query->where('preferred_package', $request->package);
        }

        if ($request->filled('looking_for')) {
            $query->where('looking_for', $request->looking_for);
        }

        $inquiries = $query->latest('id')->paginate(10)->withQueryString();

        $stats = [
            'total' => ConsultationInquiry::count(),
            'pending' => ConsultationInquiry::where('status', 'Pending Review')->count(),
            'in_progress' => ConsultationInquiry::where('status', 'In Progress')->count(),
            'verified' => ConsultationInquiry::where('status', 'Verified')->count(),
        ];

        return view('admin.inquiries.index', [
            'inquiries' => $inquiries,
            'stats' => $stats,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Display the specified inquiry details (supports AJAX/JSON).
     */
    public function show(Request $request, ConsultationInquiry $inquiry): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'inquiry' => $inquiry,
                'created_at_formatted' => $inquiry->created_at ? $inquiry->created_at->format('M d, Y h:i A') : '',
            ]);
        }

        return redirect()->route('admin.inquiries.index');
    }

    /**
     * Update the specified consultation inquiry in storage.
     */
    public function update(Request $request, ConsultationInquiry $inquiry): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'status' => [
                    'required',
                    'string',
                    Rule::in(['Pending Review', 'In Progress', 'Contacted', 'Verified', 'Closed']),
                ],
                'preferred_package' => ['nullable', 'string', 'max:100'],
                'admin_notes' => ['nullable', 'string'],
            ]);

            $inquiry->update($validated);

            return redirect()->route('admin.inquiries.index')
                ->with('success', "Inquiry #{$inquiry->inquiry_code} has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update inquiry #{$inquiry->inquiry_code}: ".$e->getMessage(), [
                'exception' => $e,
                'inquiry_id' => $inquiry->id,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to update inquiry: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Quick update of status for an inquiry.
     */
    public function updateStatus(Request $request, ConsultationInquiry $inquiry): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'status' => [
                    'required',
                    'string',
                    Rule::in(['Pending Review', 'In Progress', 'Contacted', 'Verified', 'Closed']),
                ],
            ]);

            $inquiry->status = $validated['status'];
            $inquiry->save();

            return back()->with('success', "Status for Inquiry #{$inquiry->inquiry_code} changed to '{$inquiry->status}'.");
        } catch (\Throwable $e) {
            Log::error("Failed to quick-update status for inquiry #{$inquiry->inquiry_code}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to update status: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified consultation inquiry from storage.
     */
    public function destroy(ConsultationInquiry $inquiry): RedirectResponse
    {
        try {
            $code = $inquiry->inquiry_code;
            $inquiry->delete();

            return redirect()->route('admin.inquiries.index')
                ->with('success', "Inquiry #{$code} was deleted successfully.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete inquiry #{$inquiry->inquiry_code}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete inquiry: '.$e->getMessage(),
            ]);
        }
    }
}
