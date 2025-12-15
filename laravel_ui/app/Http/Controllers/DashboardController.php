<?php

namespace App\Http\Controllers;

use App\Models\Mt;
use App\Models\RenewalJob;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        abort_unless(auth()->user()?->can('reports.view'), 403);

        // Statistics
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalServices = Service::where('status', 'active')->count();
        $totalMts = Mt::count();
        $successfulMts = Mt::where('status', 'success')->count();
        $totalRenewalJobs = RenewalJob::count();

        // Chart data - Last 30 days subscription trends
        $subscriptionTrends = Subscription::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => $item->date,
                'count' => $item->count,
            ]);

        // MT status distribution
        $mtStatusDistribution = Mt::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->status => $item->count]);

        // Renewal jobs by status
        $renewalJobsByStatus = RenewalJob::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn ($item) => [$item->status => $item->count]);

        return view('dashboard', compact(
            'totalSubscriptions',
            'activeSubscriptions',
            'totalServices',
            'totalMts',
            'successfulMts',
            'totalRenewalJobs',
            'subscriptionTrends',
            'mtStatusDistribution',
            'renewalJobsByStatus'
        ));
    }
}

