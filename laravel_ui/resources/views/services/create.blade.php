@extends('layouts.app')

@section('title', 'Create Service')

@section('content')
<div class="neo-card p-6 rounded-2xl max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6" style="color: var(--color-neo-text);">Create Service</h1>

    <form method="POST" action="{{ route('services.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="shortcode_id" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Shortcode</label>
            <select name="shortcode_id" id="shortcode_id" required class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                <option value="">Select a shortcode</option>
                @foreach($shortcodes as $shortcode)
                    <option value="{{ $shortcode->id }}" {{ old('shortcode_id') == $shortcode->id ? 'selected' : '' }}>
                        {{ $shortcode->shortcode }}@if($shortcode->description) - {{ $shortcode->description }}@endif
                    </option>
                @endforeach
            </select>
            @error('shortcode_id')
                <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="keyword" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Keyword</label>
            <input type="text" name="keyword" id="keyword" required value="{{ old('keyword') }}" 
                   class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);" 
                   placeholder="e.g., SUB" maxlength="120">
            @error('keyword')
                <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs" style="color: var(--color-neo-text-light);">Must be unique for the selected shortcode, max 120 characters</p>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Status</label>
            <select name="status" id="status" required class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center">
                <input type="checkbox" name="fpmt_enabled" id="fpmt_enabled" value="1" {{ old('fpmt_enabled') ? 'checked' : '' }} 
                       class="h-4 w-4 rounded" style="accent-color: var(--color-neo-accent);">
                <label for="fpmt_enabled" class="ml-2 block text-sm" style="color: var(--color-neo-text);">FPMT Enabled</label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="neo-button-primary px-6 py-2 text-sm font-medium">Create</button>
            <a href="{{ route('services.index') }}" class="neo-button px-6 py-2 text-sm font-medium" style="color: var(--color-neo-text);">Cancel</a>
        </div>
    </form>
</div>
@endsection

