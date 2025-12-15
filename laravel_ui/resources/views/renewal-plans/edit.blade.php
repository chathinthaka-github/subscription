@extends('layouts.app')

@section('title', 'Edit Renewal Plan')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Edit Renewal Plan</h1>
    <p class="mt-1 text-sm text-gray-500">Update the renewal schedule configuration</p>
</div>

<div class="neo-card">
    <!-- Important Notice -->
    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-amber-800">One Plan Per Service</h4>
                <p class="text-sm text-amber-700 mt-1">Updating this plan will affect all renewals for this service.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('renewal-plans.update', $renewalPlan) }}" id="planForm">
        @csrf
        @method('PUT')

        <!-- Service Selection -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="shortcode_id" class="block text-sm font-medium text-gray-700 mb-2">Shortcode</label>
                <select name="shortcode_id" id="shortcode_id" required class="neo-input">
                    <option value="">Select Shortcode</option>
                    @foreach($shortcodes as $shortcode)
                        <option value="{{ $shortcode->id }}" {{ old('shortcode_id', $renewalPlan->service->shortcode_id) == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                    @endforeach
                </select>
                @error('shortcode_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">Keyword</label>
                <select name="keyword" id="keyword" required class="neo-input">
                    <option value="{{ old('keyword', $renewalPlan->service->keyword) }}" selected>{{ old('keyword', $renewalPlan->service->keyword) }}</option>
                </select>
                @error('keyword')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name', $renewalPlan->name) }}" maxlength="100" class="neo-input">
                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Plan Configuration -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="price_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Price Code
                    <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <input type="text" name="price_code" id="price_code" value="{{ old('price_code', $renewalPlan->price_code) }}" maxlength="50" class="neo-input" placeholder="e.g., PRICE100">
                <p class="mt-1 text-xs text-gray-500">Used for billing reference</p>
                @error('price_code')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="plan_type" class="block text-sm font-medium text-gray-700 mb-2">Plan Type</label>
                <select name="plan_type" id="plan_type" required class="neo-input">
                    <option value="daily" {{ old('plan_type', $renewalPlan->plan_type) === 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ old('plan_type', $renewalPlan->plan_type) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ old('plan_type', $renewalPlan->plan_type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
                @error('plan_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="skip_subscription_day" id="skip_subscription_day" value="1" {{ old('skip_subscription_day', $renewalPlan->skip_subscription_day) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Skip Subscription Day</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_fixed_time" id="is_fixed_time" value="1" {{ old('is_fixed_time', $renewalPlan->is_fixed_time) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Use Fixed Time</span>
                </label>
            </div>
        </div>

        <!-- Fixed Time (Conditional) -->
        <div id="fixed-time" style="display: none;" class="mb-6">
            <label for="fixed_time_input" class="block text-sm font-medium text-gray-700 mb-2">Fixed Time</label>
            <input type="time" name="fixed_time" id="fixed_time_input" value="{{ old('fixed_time', $renewalPlan->fixed_time ? (is_string($renewalPlan->fixed_time) ? substr($renewalPlan->fixed_time, 0, 5) : $renewalPlan->fixed_time->format('H:i')) : '') }}" class="neo-input max-w-xs">
            <p class="mt-1 text-xs text-gray-500">Renewals will be processed at this time daily</p>
        </div>

        <!-- Weekly Days (Conditional) -->
        <div id="weekly-days" style="display: none;" class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Days of Week</label>
            @php
                $selectedDays = old('schedule_rules.days', $renewalPlan->schedule_rules['days'] ?? []);
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
                @foreach(['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7] as $day => $value)
                <label class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors border border-gray-200 has-[:checked]:bg-blue-500 has-[:checked]:border-blue-500 has-[:checked]:text-white">
                    <input type="checkbox" name="schedule_rules[days][]" value="{{ $value }}" {{ in_array($value, $selectedDays) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm font-medium">{{ $day }}</span>
                </label>
                @endforeach
            </div>
            @error('schedule_rules.days')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Monthly Days (Conditional) -->
        <div id="monthly-days" style="display: none;" class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Days of Month</label>
            @php
                $selectedDays = old('schedule_rules.days', $renewalPlan->schedule_rules['days'] ?? []);
            @endphp
            <div class="grid grid-cols-7 sm:grid-cols-10 md:grid-cols-15 gap-2">
                @for($i = 1; $i <= 31; $i++)
                <label class="relative flex items-center justify-center p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors border border-gray-200 has-[:checked]:bg-blue-500 has-[:checked]:border-blue-500 has-[:checked]:text-white">
                    <input type="checkbox" name="schedule_rules[days][]" value="{{ $i }}" {{ in_array($i, $selectedDays) ? 'checked' : '' }} class="absolute opacity-0 w-full h-full cursor-pointer">
                    <span class="text-sm font-medium">{{ $i }}</span>
                </label>
                @endfor
            </div>
            @error('schedule_rules.days')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
            <button type="submit" class="neo-button-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Renewal Plan
            </button>
            <a href="{{ route('renewal-plans.index') }}" class="neo-button">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('plan_type').addEventListener('change', function() {
        const type = this.value;
        document.getElementById('weekly-days').style.display = type === 'weekly' ? 'block' : 'none';
        document.getElementById('monthly-days').style.display = type === 'monthly' ? 'block' : 'none';
    });

    document.getElementById('is_fixed_time').addEventListener('change', function() {
        document.getElementById('fixed-time').style.display = this.checked ? 'block' : 'none';
    });

    // AJAX keyword population
    const currentShortcodeId = {{ old('shortcode_id', $renewalPlan->service->shortcode_id) }};
    const currentKeyword = '{{ old('keyword', $renewalPlan->service->keyword) }}';
    
    document.getElementById('shortcode_id').addEventListener('change', function() {
        const shortcodeId = this.value;
        const keywordSelect = document.getElementById('keyword');
        
        keywordSelect.disabled = true;
        keywordSelect.innerHTML = '<option value="">Loading...</option>';
        
        if (!shortcodeId) {
            keywordSelect.innerHTML = '<option value="">Select Shortcode First</option>';
            return;
        }
        
        fetch(`/api/plan-keywords/${shortcodeId}`)
            .then(response => response.json())
            .then(data => {
                keywordSelect.innerHTML = '<option value="">Select Keyword</option>';
                data.forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.keyword;
                    option.textContent = item.keyword;
                    if (item.keyword === currentKeyword && shortcodeId == currentShortcodeId) {
                        option.selected = true;
                    }
                    keywordSelect.appendChild(option);
                });
                keywordSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                keywordSelect.innerHTML = '<option value="">Error loading keywords</option>';
            });
    });
    
    // Load keywords on page load if shortcode is selected
    if (currentShortcodeId) {
        document.getElementById('shortcode_id').dispatchEvent(new Event('change'));
    }

    // Trigger on load
    document.getElementById('plan_type').dispatchEvent(new Event('change'));
    document.getElementById('is_fixed_time').dispatchEvent(new Event('change'));
</script>
@endsection
