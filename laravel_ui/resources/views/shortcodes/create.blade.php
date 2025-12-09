@extends('layouts.app')

@section('title', 'Create Shortcode')

@section('content')
<div class="neo-card p-6 rounded-2xl max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6" style="color: var(--color-neo-text);">Create Shortcode</h1>

    <form method="POST" action="{{ route('shortcodes.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="shortcode" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Shortcode</label>
            <input type="text" name="shortcode" id="shortcode" required value="{{ old('shortcode') }}" 
                   class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);" 
                   placeholder="e.g., 1234" maxlength="20" pattern="[A-Z0-9]+" title="Uppercase letters and numbers only">
            @error('shortcode')
                <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs" style="color: var(--color-neo-text-light);">Uppercase letters and numbers only, max 20 characters</p>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium mb-2" style="color: var(--color-neo-text);">Description</label>
            <textarea name="description" id="description" rows="3" 
                      class="neo-input px-4 py-2 w-full" style="color: var(--color-neo-text);" 
                      placeholder="Optional description">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm" style="color: var(--color-neo-error);">{{ $message }}</p>
            @enderror
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

        <div class="flex gap-4">
            <button type="submit" class="neo-button-primary px-6 py-2 text-sm font-medium">Create</button>
            <a href="{{ route('shortcodes.index') }}" class="neo-button px-6 py-2 text-sm font-medium" style="color: var(--color-neo-text);">Cancel</a>
        </div>
    </form>
</div>
@endsection

