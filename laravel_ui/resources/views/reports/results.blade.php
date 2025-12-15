@extends('layouts.app')

@section('title', 'Report Results')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $reportType)) }} Report</h1>
        <p class="mt-1 text-sm text-gray-500">Found {{ $results->total() }} {{ Str::plural('result', $results->total()) }}</p>
    </div>
    <div class="mt-4 sm:mt-0 flex gap-3">
        <a href="{{ route('reports.index') }}" class="neo-button inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            New Search
        </a>
    </div>
</div>

<!-- Results Card -->
<div class="neo-card overflow-hidden p-0">
    <div class="overflow-x-auto">
        @if($reportType === 'renewal_job')
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>MSISDN</th>
                    <th>Status</th>
                    <th>Queued At</th>
                    <th>Processed At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td class="font-medium text-gray-900">{{ $result->id }}</td>
                    <td>{{ $result->service->shortcode->shortcode ?? '-' }} - {{ $result->service->keyword ?? '-' }}</td>
                    <td>{{ $result->msisdn }}</td>
                    <td>
                        @php
                            $statusClass = match($result->status) {
                                'done' => 'badge-success',
                                'failed' => 'badge-danger',
                                'processing' => 'badge-info',
                                default => 'badge-warning'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($result->status) }}</span>
                    </td>
                    <td>{{ $result->queued_at?->format('M d, Y H:i') ?? '-' }}</td>
                    <td>{{ $result->processed_at?->format('M d, Y H:i') ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        No renewal jobs found matching your criteria
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'subscription')
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>MSISDN</th>
                    <th>Status</th>
                    <th>Subscribed At</th>
                    <th>Next Renewal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td class="font-medium text-gray-900">{{ $result->id }}</td>
                    <td>{{ $result->service->shortcode->shortcode ?? '-' }} - {{ $result->service->keyword ?? '-' }}</td>
                    <td>{{ $result->msisdn }}</td>
                    <td>
                        @php
                            $statusClass = match($result->status) {
                                'active' => 'badge-success',
                                'cancelled' => 'badge-danger',
                                'suspended' => 'badge-warning',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($result->status) }}</span>
                    </td>
                    <td>{{ $result->subscribed_at?->format('M d, Y H:i') ?? '-' }}</td>
                    <td>{{ $result->next_renewal_at?->format('M d, Y H:i') ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        No subscriptions found matching your criteria
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @elseif($reportType === 'mt')
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MT Ref ID</th>
                    <th>MSISDN</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>DN Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                <tr>
                    <td class="font-medium text-gray-900">{{ $result->id }}</td>
                    <td class="font-mono text-xs">{{ $result->mt_ref_id }}</td>
                    <td>{{ $result->msisdn }}</td>
                    <td><span class="badge badge-info">{{ $result->message_type }}</span></td>
                    <td>
                        @php
                            $statusClass = match($result->status) {
                                'success' => 'badge-success',
                                'fail' => 'badge-danger',
                                default => 'badge-warning'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($result->status) }}</span>
                    </td>
                    <td>
                        @php
                            $dnClass = match($result->dn_status) {
                                'delivered' => 'badge-success',
                                'failed' => 'badge-danger',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge {{ $dnClass }}">{{ ucfirst($result->dn_status) }}</span>
                    </td>
                    <td>{{ $result->created_at?->format('M d, Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        No MT messages found matching your criteria
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @endif
    </div>
    
    <!-- Pagination -->
    @if($results->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $results->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
