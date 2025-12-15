@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
        <p class="mt-1 text-sm text-gray-500">Search and analyze your subscription data</p>
    </div>
</div>

<!-- Search Form -->
<div class="neo-card">
    <form method="POST" action="{{ route('reports.search') }}" id="reportForm">
        @csrf
        
        <!-- Quick Date Filters -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button type="button" onclick="setDateRange('today')" class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                Today
            </button>
            <button type="button" onclick="setDateRange('7days')" class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                Last 7 Days
            </button>
            <button type="button" onclick="setDateRange('30days')" class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                Last 30 Days
            </button>
            <button type="button" onclick="setDateRange('thisMonth')" class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                This Month
            </button>
            <button type="button" onclick="clearFilters()" class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 text-red-500 hover:bg-red-50 transition-colors">
                Clear All
            </button>
        </div>

        <!-- Filter Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Report Type -->
            <div>
                <label for="report_type" class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                <select name="report_type" id="report_type" required class="neo-input">
                    <option value="">Select Report Type</option>
                    <option value="subscription" {{ old('report_type') === 'subscription' ? 'selected' : '' }}>Subscriptions</option>
                    <option value="mt" {{ old('report_type') === 'mt' ? 'selected' : '' }}>MT Messages</option>
                    <option value="renewal_job" {{ old('report_type') === 'renewal_job' ? 'selected' : '' }}>Renewal Jobs</option>
                </select>
                @error('report_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date From -->
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                <input type="date" name="date_from" id="date_from" value="{{ old('date_from') }}" class="neo-input">
                @error('date_from')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date To -->
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                <input type="date" name="date_to" id="date_to" value="{{ old('date_to') }}" class="neo-input">
                @error('date_to')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Service -->
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                <select name="service_id" id="service_id" class="neo-input">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->shortcode->shortcode }} - {{ $service->keyword }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- MSISDN -->
            <div>
                <label for="msisdn" class="block text-sm font-medium text-gray-700 mb-2">MSISDN</label>
                <input type="text" name="msisdn" id="msisdn" value="{{ old('msisdn') }}" placeholder="e.g., +94771234567" class="neo-input">
                @error('msisdn')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="neo-input">
                    <option value="">All Statuses</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="neo-button-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Search Reports
            </button>
            <button type="button" onclick="exportReport()" class="neo-button">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
            </button>
        </div>
    </form>
</div>

<!-- Help Section -->
<div class="mt-8 p-6 bg-blue-50 rounded-xl border border-blue-100">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-blue-800">Report Types</h4>
            <ul class="mt-2 text-sm text-blue-700 space-y-1">
                <li><strong>Subscriptions:</strong> View all subscription records with status and renewal information</li>
                <li><strong>MT Messages:</strong> Track all Mobile Terminated messages and their delivery status</li>
                <li><strong>Renewal Jobs:</strong> Monitor scheduled renewal attempts and their outcomes</li>
            </ul>
        </div>
    </div>
</div>

<script>
    const statusOptions = {
        subscription: ['pending', 'active', 'suspended', 'cancelled'],
        mt: ['queued', 'success', 'fail'],
        renewal_job: ['queued', 'processing', 'done', 'failed']
    };

    const statusSelect = document.getElementById('status');
    const reportTypeSelect = document.getElementById('report_type');
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');

    // Update status options based on report type
    reportTypeSelect.addEventListener('change', function() {
        const type = this.value;
        statusSelect.innerHTML = '<option value="">All Statuses</option>';
        
        if (type && statusOptions[type]) {
            statusOptions[type].forEach(status => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
                statusSelect.appendChild(option);
            });
        }
    });

    // Quick date range setters
    function setDateRange(range) {
        const today = new Date();
        let fromDate = new Date();
        
        switch(range) {
            case 'today':
                fromDate = today;
                break;
            case '7days':
                fromDate.setDate(today.getDate() - 7);
                break;
            case '30days':
                fromDate.setDate(today.getDate() - 30);
                break;
            case 'thisMonth':
                fromDate = new Date(today.getFullYear(), today.getMonth(), 1);
                break;
        }
        
        dateFrom.value = fromDate.toISOString().split('T')[0];
        dateTo.value = today.toISOString().split('T')[0];
    }

    function clearFilters() {
        document.getElementById('reportForm').reset();
        statusSelect.innerHTML = '<option value="">All Statuses</option>';
    }

    function exportReport() {
        alert('Export functionality will be implemented based on the selected filters.');
    }

    // Trigger on page load to set status options if report_type is selected
    if (reportTypeSelect.value) {
        reportTypeSelect.dispatchEvent(new Event('change'));
    }
</script>
@endsection
