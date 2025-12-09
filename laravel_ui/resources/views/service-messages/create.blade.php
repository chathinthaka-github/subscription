@extends('layouts.app')

@section('title', 'Create Service Message')

@section('content')
<div class="px-4 sm:px-6 lg:px-8" style="background: #fff;">
    <h1 class="text-2xl font-semibold" style="color: #000;">Create Service Message</h1>

    <form method="POST" action="{{ route('service-messages.store') }}" class="mt-8 space-y-6 max-w-2xl">
        @csrf

        <div>
            <label for="shortcode_id" class="block text-sm font-medium" style="color: #000;">Shortcode</label>
            <select name="shortcode_id" id="shortcode_id" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="">Select Shortcode</option>
                @foreach($shortcodes as $shortcode)
                    <option value="{{ $shortcode->id }}" {{ old('shortcode_id') == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                @endforeach
            </select>
            @error('shortcode_id')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keyword" class="block text-sm font-medium" style="color: #000;">Keyword</label>
            <select name="keyword" id="keyword" required disabled class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="">Select Shortcode First</option>
            </select>
            @error('keyword')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="message_type" class="block text-sm font-medium" style="color: #000;">Message Type</label>
            <select name="message_type" id="message_type" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="FPMT" {{ old('message_type') === 'FPMT' ? 'selected' : '' }}>FPMT</option>
                <option value="RENEWAL" {{ old('message_type') === 'RENEWAL' ? 'selected' : '' }}>RENEWAL</option>
            </select>
            @error('message_type')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium" style="color: #000;">Status</label>
            <select name="status" id="status" required class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium" style="color: #000;">Message <span id="char-count" style="color: #666;">(0/260)</span></label>
            <textarea name="message" id="message" required maxlength="260" rows="4" class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">{{ old('message') }}</textarea>
            @error('message')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price_code" class="block text-sm font-medium" style="color: #000;">Price Code</label>
            <input type="text" name="price_code" id="price_code" required value="{{ old('price_code') }}" maxlength="50" class="mt-1 block w-full rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
            @error('price_code')
                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">Create</button>
            <a href="{{ route('service-messages.index') }}" class="inline-flex items-center px-4 py-2 border border-black text-sm font-medium rounded-md" style="color: #000; background: #fff;">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('message').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('char-count').textContent = `(${count}/260)`;
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
        
        fetch(`/api/keywords/${shortcodeId}`)
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
</script>
@endsection

