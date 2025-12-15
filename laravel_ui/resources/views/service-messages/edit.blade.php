@extends('layouts.app')

@section('title', 'Edit Service Message')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Edit Service Message</h1>
    <p class="mt-1 text-sm text-gray-500">Update the message configuration</p>
</div>

<div class="neo-card">
    <form method="POST" action="{{ route('service-messages.update', $serviceMessage) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Shortcode -->
            <div>
                <label for="shortcode_id" class="block text-sm font-medium text-gray-700 mb-2">Shortcode</label>
                <select name="shortcode_id" id="shortcode_id" required class="neo-input">
                    <option value="">Select Shortcode</option>
                    @foreach($shortcodes as $shortcode)
                        <option value="{{ $shortcode->id }}" {{ old('shortcode_id', $serviceMessage->service->shortcode_id) == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                    @endforeach
                </select>
                @error('shortcode_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keyword -->
            <div>
                <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">Keyword</label>
                <select name="keyword" id="keyword" required class="neo-input">
                    <option value="{{ old('keyword', $serviceMessage->service->keyword) }}" selected>{{ old('keyword', $serviceMessage->service->keyword) }}</option>
                </select>
                @error('keyword')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Message Type -->
            <div>
                <label for="message_type" class="block text-sm font-medium text-gray-700 mb-2">Message Type</label>
                <select name="message_type" id="message_type" required class="neo-input">
                    <option value="FPMT" {{ old('message_type', $serviceMessage->message_type) === 'FPMT' ? 'selected' : '' }}>FPMT</option>
                    <option value="RENEWAL" {{ old('message_type', $serviceMessage->message_type) === 'RENEWAL' ? 'selected' : '' }}>RENEWAL</option>
                </select>
                @error('message_type')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" required class="neo-input">
                    <option value="active" {{ old('status', $serviceMessage->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $serviceMessage->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Message -->
        <div class="mb-6">
            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                Message Content
                <span id="char-count" class="text-gray-400 font-normal">({{ strlen(old('message', $serviceMessage->message)) }}/260)</span>
            </label>
            <textarea name="message" id="message" required maxlength="260" rows="4" class="neo-input" placeholder="Enter the message content...">{{ old('message', $serviceMessage->message) }}</textarea>
            @error('message')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
            <button type="submit" class="neo-button-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Message
            </button>
            <a href="{{ route('service-messages.index') }}" class="neo-button">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('message').addEventListener('input', function() {
        const count = this.value.length;
        document.getElementById('char-count').textContent = `(${count}/260)`;
    });

    // AJAX keyword population
    const currentShortcodeId = {{ old('shortcode_id', $serviceMessage->service->shortcode_id) }};
    const currentKeyword = '{{ old('keyword', $serviceMessage->service->keyword) }}';
    
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
</script>
@endsection
