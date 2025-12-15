@extends('layouts.app')

@section('title', 'Report Results')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold" style="color: var(--color-neo-text);">Report Results - {{ ucfirst(str_replace('_', ' ', $reportType)) }}</h1>
            <p class="mt-2 text-sm" style="color: var(--color-neo-text-light);">Total Results: {{ $results->total() }}</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('reports.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">New Search</a>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                @if($reportType === 'renewal_job')
                <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: var(--color-neo-text);">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Queued At</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Processed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->service->shortcode->shortcode ?? '-' }} - {{ $result->service->keyword ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $result->status === 'done' ? 'bg-green-100 text-green-800' : ($result->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $result->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->queued_at }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->processed_at ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No results found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType === 'subscription')
                <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: var(--color-neo-text);">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Subscribed At</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->service->shortcode->shortcode ?? '-' }} - {{ $result->service->keyword ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $result->status === 'active' ? 'bg-green-100 text-green-800' : ($result->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $result->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->subscribed_at }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->updated_at ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No results found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType === 'mt')
                <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: var(--color-neo-text);">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Message</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">DN Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">MT Ref ID</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->service->shortcode ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->message_type }}</td>
                            <td class="px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ Str::limit($result->message_content ?? '-', 50) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $result->status === 'success' ? 'bg-green-100 text-green-800' : ($result->status === 'fail' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $result->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->dn_status }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $result->mt_ref_id }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No results found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
</div>
@endsection

