<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRenewalPlanRequest;
use App\Http\Requests\UpdateRenewalPlanRequest;
use App\Models\RenewalPlan;
use App\Models\Service;
use App\Models\Shortcode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RenewalPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        abort_unless(auth()->user()?->can('renewal_plan.view'), 403);

        $query = RenewalPlan::with('service.shortcode');

        if ($request->filled('shortcode_id')) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('shortcode_id', $request->shortcode_id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('service', function ($q) use ($search) {
                $q->whereHas('shortcode', function ($sq) use ($search) {
                    $sq->where('shortcode', 'like', "%{$search}%");
                })->orWhere('keyword', 'like', "%{$search}%");
            });
        }

        $plans = $query->latest()->paginate(15);
        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();

        return view('renewal-plans.index', compact('plans', 'shortcodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        abort_unless(auth()->user()?->can('renewal_plan.create'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();

        return view('renewal-plans.create', compact('shortcodes'));
    }

    /**
     * Get keywords for a shortcode (AJAX endpoint).
     */
    public function getKeywords(Shortcode $shortcode): JsonResponse
    {
        $keywords = Service::where('shortcode_id', $shortcode->id)
            ->where('status', 'active')
            ->orderBy('keyword')
            ->get(['id', 'keyword'])
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'keyword' => $service->keyword,
                ];
            });

        return response()->json($keywords);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRenewalPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Resolve service_id from shortcode_id + keyword
        $service = Service::where('shortcode_id', $data['shortcode_id'])
            ->where('keyword', $data['keyword'])
            ->where('status', 'active')
            ->firstOrFail();
        
        $data['service_id'] = $service->id;
        unset($data['shortcode_id'], $data['keyword']);
        
        $data['schedule_rules'] = $this->buildScheduleRules($data);

        // Use updateOrCreate since each service can only have one renewal plan
        RenewalPlan::updateOrCreate(
            ['service_id' => $data['service_id']],
            $data
        );

        return redirect()->route('renewal-plans.index')
            ->with('success', 'Renewal plan saved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RenewalPlan $renewalPlan): View
    {
        abort_unless(auth()->user()?->can('renewal_plan.update'), 403);

        $shortcodes = Shortcode::where('status', 'active')->orderBy('shortcode')->get();
        $renewalPlan->load('service.shortcode');

        return view('renewal-plans.edit', compact('renewalPlan', 'shortcodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRenewalPlanRequest $request, RenewalPlan $renewalPlan): RedirectResponse
    {
        $data = $request->validated();
        
        // Resolve service_id from shortcode_id + keyword
        $service = Service::where('shortcode_id', $data['shortcode_id'])
            ->where('keyword', $data['keyword'])
            ->where('status', 'active')
            ->firstOrFail();
        
        $data['service_id'] = $service->id;
        unset($data['shortcode_id'], $data['keyword']);
        
        $data['schedule_rules'] = $this->buildScheduleRules($data);

        $renewalPlan->update($data);

        return redirect()->route('renewal-plans.index')
            ->with('success', 'Renewal plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RenewalPlan $renewalPlan): RedirectResponse
    {
        abort_unless(auth()->user()?->can('renewal_plan.delete'), 403);

        $renewalPlan->delete();

        return redirect()->route('renewal-plans.index')
            ->with('success', 'Renewal plan deleted successfully.');
    }

    /**
     * Build schedule rules JSON from request data.
     */
    private function buildScheduleRules(array $data): array
    {
        $rules = [
            'plan_type' => $data['plan_type'],
            'skip_subscription_day' => $data['skip_subscription_day'] ?? false,
            'is_fixed_time' => $data['is_fixed_time'] ?? false,
        ];

        if ($rules['is_fixed_time'] && isset($data['fixed_time'])) {
            $rules['fixed_time'] = $data['fixed_time'];
        }

        if (($data['plan_type'] === 'weekly' || $data['plan_type'] === 'monthly') && isset($data['schedule_rules'])) {
    $rules['days'] = $data['schedule_rules']['days'] ?? [];
}

        return $rules;
    }
}

