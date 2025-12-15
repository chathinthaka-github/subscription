@extends('layouts.app')

@section('title', 'Create Renewal Plan')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <h1 class="text-3xl font-semibold mb-6" style="color: var(--color-neo-text);">Create Renewal Plan</h1>

    <!-- Important Constraint Warning -->
    <div class="neo-card p-4 rounded-xl mb-6" style="background: rgba(251, 191, 36, 0.1); border: 2px solid rgba(251, 191, 36, 0.4);">
        <div class="flex items-start">
            <svg class="h-6 w-6 flex-shrink-0 mt-0.5" style="color: var(--color-neo-warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div class="ml-3">
                <h3 class="text-sm font-semibold" style="color: var(--color-neo-warning);">Important: Unique Service Constraint</h3>
                <p class="mt-1 text-sm" style="color: var(--color-neo-text);">Each service can only have ONE renewal plan. Creating a new plan for an existing service will replace the current plan.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('renewal-plans.store') }}" id="planForm">
        @csrf

        <!-- First Row: Shortcode, Keyword, Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="shortcode_id" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Shortcode</label>
                <select name="shortcode_id" id="shortcode_id" required class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="">Select Shortcode</option>
                    @foreach($shortcodes as $shortcode)
                        <option value="{{ $shortcode->id }}" {{ old('shortcode_id') == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                    @endforeach
                </select>
                @error('shortcode_id')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keyword" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Keyword</label>
                <select name="keyword" id="keyword" required disabled class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="">Select Shortcode First</option>
                </select>
                @error('keyword')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Plan Name</label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" maxlength="100" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                @error('name')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Second Row: Price, Plan Type, Skip/Fixed Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="price_code" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Price</label>
                <input type="text" name="price_code" id="price_code" required value="{{ old('price_code') }}" maxlength="50" class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                @error('price_code')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="plan_type" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Plan Type</label>
                <select name="plan_type" id="plan_type" required class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                    <option value="daily" {{ old('plan_type') === 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ old('plan_type') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ old('plan_type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
                @error('plan_type')
                    <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3">
                <div class="flex items-center">
                    <input type="checkbox" name="skip_subscription_day" id="skip_subscription_day" value="1" {{ old('skip_subscription_day') ? 'checked' : '' }} class="h-4 w-4 rounded" style="accent-color: var(--color-neo-accent);">
                    <label for="skip_subscription_day" class="ml-2 block text-sm" style="color: var(--color-neo-text);">Skip Subscription Day</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_fixed_time" id="is_fixed_time" value="1" {{ old('is_fixed_time') ? 'checked' : '' }} class="h-4 w-4 rounded" style="accent-color: var(--color-neo-accent);">
                    <label for="is_fixed_time" class="ml-2 block text-sm" style="color: var(--color-neo-text);">Use Fixed Time</label>
                </div>
            </div>
        </div>

        <!-- Fixed Time Field (conditionally shown) -->
        <div id="fixed-time" style="display: none;" class="mb-6">
            <label for="fixed_time" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Fixed Time</label>
            <input type="time" name="fixed_time" id="fixed_time_input" value="{{ old('fixed_time') }}" class="neo-input px-4 py-2 w-full max-w-xs" style="color: var(--color-neo-text);">
        </div>

        <!-- Weekly Days Selection (full width) -->
        <div id="weekly-days" style="display: none;" class="mb-6">
            <label class="block text-sm font-medium mb-3" style="color: var(--color-neo-text);">Days of Week</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-4">
                @foreach(['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7] as $day => $value)
                <label class="flex items-center neo-card p-3 rounded-lg cursor-pointer hover:shadow-lg transition-shadow">
                    <input type="checkbox" name="schedule_rules[days][]" value="{{ $value }}" class="h-4 w-4 rounded" style="accent-color: var(--color-neo-accent);">
                    <span class="ml-2 text-sm font-medium" style="color: var(--color-neo-text);">{{ $day }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Monthly Days Selection (full width) -->
        <div id="monthly-days" style="display: none;" class="mb-6">
            <label class="block text-sm font-medium mb-3" style="color: var(--color-neo-text);">Days of Month</label>
            <div class="grid grid-cols-4 sm:grid-cols-7 md:grid-cols-10 lg:grid-cols-15 gap-2">
                @for($i = 1; $i <= 31; $i++)
                <label class="flex items-center justify-center neo-card p-2 rounded-lg cursor-pointer hover:shadow-lg transition-shadow">
                    <input type="checkbox" name="schedule_rules[days][]" value="{{ $i }}" class="h-4 w-4 rounded" style="accent-color: var(--color-neo-accent);">
                    <span class="ml-1 text-sm font-medium" style="color: var(--color-neo-text);">{{ $i }}</span>
                </label>
                @endfor
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-4">
            <button type="submit" class="neo-button-primary px-6 py-3 text-sm font-medium">Create Renewal Plan</button>
            <a href="{{ route('renewal-plans.index') }}" class="neo-button px-6 py-3 text-sm font-medium" style="color: var(--color-neo-text);">Cancel</a>
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
                    keywordSelect.appendChild(option);
                });
                keywordSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                keywordSelect.innerHTML = '<option value="">Error loading keywords</option>';
            });
    });

    // Trigger on load
    document.getElementById('plan_type').dispatchEvent(new Event('change'));
    document.getElementById('is_fixed_time').dispatchEvent(new Event('change'));
</script>
@endsection
