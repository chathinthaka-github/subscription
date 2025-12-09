@extends('layouts.app')

@section('title', 'Report Results')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Report Results - {{ ucfirst(str_replace('_', ' ', $reportType)) }}</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">New Search</a>
        </div>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                @if($reportType === 'renewal_job')
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Queued At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->service->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->status }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->queued_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-sm text-gray-500">No results found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType === 'subscription')
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Subscribed At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->service->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->status }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->subscribed_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-sm text-gray-500">No results found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType === 'mt')
                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Service</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">MSISDN</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">DN Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">MT Ref ID</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($results as $result)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ $result->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->service->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->msisdn }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->message_type }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->status }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->dn_status }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $result->mt_ref_id }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-sm text-gray-500">No results found</td>
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

