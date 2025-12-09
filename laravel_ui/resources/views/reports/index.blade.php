@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Reports</h1>

    <form method="POST" action="{{ route('reports.search') }}" class="mt-8 space-y-6 max-w-2xl">
        @csrf

        <div>
            <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
            <select name="report_type" id="report_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Select Report Type</option>
                <option value="renewal_job" {{ old('report_type') === 'renewal_job' ? 'selected' : '' }}>Renewal Jobs</option>
                <option value="subscription" {{ old('report_type') === 'subscription' ? 'selected' : '' }}>Subscriptions</option>
                <option value="mt" {{ old('report_type') === 'mt' ? 'selected' : '' }}>MT Records</option>
            </select>
            @error('report_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date From</label>
            <input type="date" name="date_from" id="date_from" value="{{ old('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date To</label>
            <input type="date" name="date_to" id="date_to" value="{{ old('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Service</label>
            <select name="service_id" id="service_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">All Services</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->shortcode }} - {{ $service->keyword }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="msisdn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">MSISDN</label>
            <input type="text" name="msisdn" id="msisdn" value="{{ old('msisdn') }}" placeholder="e.g., +1234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>

        <div id="status-field" style="display: none;">
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">All Statuses</option>
            </select>
        </div>

        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Search</button>
        </div>
    </form>
</div>

<script>
    const statusOptions = {
        renewal_job: ['queued', 'processing', 'done', 'failed'],
        subscription: ['pending', 'active', 'suspended', 'cancelled'],
        mt: ['queued', 'success', 'fail']
    };

    document.getElementById('report_type').addEventListener('change', function() {
        const type = this.value;
        const statusField = document.getElementById('status-field');
        const statusSelect = document.getElementById('status');

        if (type && statusOptions[type]) {
            statusField.style.display = 'block';
            statusSelect.innerHTML = '<option value="">All Statuses</option>';
            statusOptions[type].forEach(status => {
                statusSelect.innerHTML += `<option value="${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</option>`;
            });
        } else {
            statusField.style.display = 'none';
        }
    });
</script>
@endsection

