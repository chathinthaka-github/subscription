@extends('layouts.app')

@section('title', 'Edit Renewal Plan')

@section('content')
<div class="px-4 sm:px-6 lg:px-8" style="background: #fff;">
    <h1 class="text-2xl font-semibold" style="color: #000;">Edit Renewal Plan</h1>

    <form method="POST" action="{{ route('renewal-plans.update', $renewalPlan) }}" class="mt-8 space-y-6 max-w-2xl" id="planForm">
        @csrf
        @method('PUT')

        <div>
            <label for="shortcode_id" class="block text-sm font-medium" style="color: #000;">Shortcode</label>
            <select name="shortcode_id" id="shortcode_id" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="">Select Shortcode</option>
                @foreach($shortcodes as $shortcode)
                    <option value="{{ $shortcode->id }}" {{ old('shortcode_id', $renewalPlan->service->shortcode_id) == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                @endforeach
            </select>
            @error('shortcode_id')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keyword" class="block text-sm font-medium" style="color: #000;">Keyword</label>
            <select name="keyword" id="keyword" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="{{ old('keyword', $renewalPlan->service->keyword) }}" selected>{{ old('keyword', $renewalPlan->service->keyword) }}</option>
            </select>
            @error('keyword')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="name" class="block text-sm font-medium" style="color: #000;">Plan Name</label>
            <input type="text" name="name" id="name" required value="{{ old('name', $renewalPlan->name) }}" maxlength="100" class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
            @error('name')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price_code" class="block text-sm font-medium" style="color: #000;">Price Code</label>
            <input type="text" name="price_code" id="price_code" required value="{{ old('price_code', $renewalPlan->price_code) }}" maxlength="50" class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
            @error('price_code')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="plan_type" class="block text-sm font-medium" style="color: #000;">Plan Type</label>
            <select name="plan_type" id="plan_type" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="daily" {{ old('plan_type', $renewalPlan->plan_type) === 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ old('plan_type', $renewalPlan->plan_type) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ old('plan_type', $renewalPlan->plan_type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>

        <div id="weekly-days" style="display: none;">
            <label class="block text-sm font-medium" style="color: #000;">Days of Week</label>
            <div class="mt-2 flex gap-4">
                @php
                    $selectedDays = old('schedule_rules.days', $renewalPlan->schedule_rules['days'] ?? []);
                @endphp
                @foreach(['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7] as $day => $value)
                <label class="flex items-center">
                    <input type="checkbox" name="schedule_rules[days][]" value="{{ $value }}" {{ in_array($value, $selectedDays) ? 'checked' : '' }} class="rounded border-black text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-sm" style="color: #000;">{{ substr($day, 0, 3) }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div id="monthly-days" style="display: none;">
            <label class="block text-sm font-medium" style="color: #000;">Days of Month</label>
            <select name="schedule_rules[days][]" multiple class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" size="10" style="color: #000; background: #fff;">
                @php
                    $selectedDays = old('schedule_rules.days', $renewalPlan->schedule_rules['days'] ?? []);
                @endphp
                @for($i = 1; $i <= 31; $i++)
                <option value="{{ $i }}" {{ in_array($i, $selectedDays) ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div>
            <div class="flex items-center">
                <input type="checkbox" name="skip_subscription_day" id="skip_subscription_day" value="1" {{ old('skip_subscription_day', $renewalPlan->skip_subscription_day) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-black rounded">
                <label for="skip_subscription_day" class="ml-2 block text-sm" style="color: #000;">Skip Subscription Day</label>
            </div>
        </div>

        <div>
            <div class="flex items-center">
                <input type="checkbox" name="is_fixed_time" id="is_fixed_time" value="1" {{ old('is_fixed_time', $renewalPlan->is_fixed_time) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-black rounded">
                <label for="is_fixed_time" class="ml-2 block text-sm" style="color: #000;">Use Fixed Time</label>
            </div>
        </div>

        <div id="fixed-time" style="display: none;">
            <label for="fixed_time" class="block text-sm font-medium" style="color: #000;">Fixed Time</label>
            <input type="time" name="fixed_time" id="fixed_time" value="{{ old('fixed_time', $renewalPlan->fixed_time ? (is_string($renewalPlan->fixed_time) ? substr($renewalPlan->fixed_time, 0, 5) : $renewalPlan->fixed_time->format('H:i')) : '') }}" class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Update</button>
            <a href="{{ route('renewal-plans.index') }}" class="inline-flex items-center px-4 py-2 border border-black text-sm font-medium rounded-md" style="color: #000; background: #fff;">Cancel</a>
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

