@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <h1 class="text-3xl font-semibold mb-6" style="color: var(--color-neo-text);">Reports</h1>

    <form method="POST" action="{{ route('reports.search') }}" class="mt-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label for="report_type" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Report Type</label>
                <select name="report_type" id="report_type" required class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="">Select Report Type</option>
                    <option value="renewal_job" {{ old('report_type') === 'renewal_job' ? 'selected' : '' }}>Renewal Jobs</option>
                    <option value="subscription" {{ old('report_type') === 'subscription' ? 'selected' : '' }}>Subscriptions</option>
                    <option value="mt" {{ old('report_type') === 'mt' ? 'selected' : '' }}>MT Records</option>
                </select>
                @error('report_type')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date_from" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Date From</label>
                <input type="date" name="date_from" id="date_from" value="{{ old('date_from') }}" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                @error('date_from')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date_to" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Date To</label>
                <input type="date" name="date_to" id="date_to" value="{{ old('date_to') }}" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                @error('date_to')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="service_id" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Service</label>
                <select name="service_id" id="service_id" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->shortcode->shortcode }} - {{ $service->keyword }}</option>
                    @endforeach
                </select>
                @error('service_id')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="msisdn" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">MSISDN</label>
                <input type="text" name="msisdn" id="msisdn" value="{{ old('msisdn') }}" placeholder="e.g., +1234567890" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                @error('msisdn')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div id="status-field" style="display: none;">
                <label for="status" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Status</label>
                <select name="status" id="status" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="">All Statuses</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8">
            <button type="submit" class="neo-button-primary px-6 py-3 text-sm font-medium">Search Reports</button>
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

