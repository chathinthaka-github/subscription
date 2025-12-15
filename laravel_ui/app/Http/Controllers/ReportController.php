<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchReportRequest;
use App\Models\Mt;
use App\Models\RenewalJob;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the report search form.
     */
    public function index(): View
    {
        abort_unless(auth()->user()?->can('reports.view'), 403);

        $services = Service::where('status', 'active')->get();

        return view('reports.index', compact('services'));
    }

    /**
     * Search and display report results.
     */
    public function search(SearchReportRequest $request): View
    {
        abort_unless(auth()->user()?->can('reports.view'), 403);

        $services = Service::where('status', 'active')->get();
        $results = collect();
        $reportType = $request->report_type;

        switch ($reportType) {
            case 'renewal_job':
                $results = $this->searchRenewalJobs($request);
                break;
            case 'subscription':
                $results = $this->searchSubscriptions($request);
                break;
            case 'mt':
                $results = $this->searchMts($request);
                break;
        }

        return view('reports.results', compact('results', 'reportType', 'services', 'request'));
    }

    /**
     * Search renewal jobs.
     */
    private function searchRenewalJobs(Request $request)
    {
        $query = RenewalJob::with(['service.shortcode', 'subscription']);

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to.' 23:59:59');
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('msisdn')) {
            $query->where('msisdn', $request->msisdn);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->paginate(50);
    }

    /**
     * Search subscriptions.
     */
    private function searchSubscriptions(Request $request)
    {
        // Note: renewalPlan is now derived via service, not eager loaded
        $query = Subscription::with(['service.shortcode', 'service.renewalPlans']);

        if ($request->filled('date_from')) {
            $query->where('subscribed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('subscribed_at', '<=', $request->date_to.' 23:59:59');
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('msisdn')) {
            $query->where('msisdn', $request->msisdn);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->paginate(50);
    }

    /**
     * Search MTs.
     */
    private function searchMts(Request $request)
    {
        $query = Mt::with(['service', 'subscription']);

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to.' 23:59:59');
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('msisdn')) {
            $query->where('msisdn', $request->msisdn);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->paginate(50);
    }
}

