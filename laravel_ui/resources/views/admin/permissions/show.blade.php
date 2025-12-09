@extends('layouts.app')

@section('title', 'Manage Permissions: ' . ucfirst($role->name))

@section('content')
<div class="neo-card p-6 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: var(--color-neo-text);">Manage Permissions: {{ ucfirst($role->name) }}</h1>
            <p class="mt-1 text-sm" style="color: var(--color-neo-text-light);">Select permissions to assign to this role</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.permissions.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Back to Roles</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.permissions.update', $role) }}" class="space-y-6">
        @csrf
        @method('POST')

        @foreach($allPermissions as $module => $permissions)
        <div class="neo-card p-4 rounded-xl">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--color-neo-text);">{{ ucfirst($module) }}</h3>
            <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                @foreach($permissions as $permission)
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="permissions[]" 
                           id="permission_{{ $permission->id }}" 
                           value="{{ $permission->id }}"
                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                           class="h-4 w-4 rounded" 
                           style="accent-color: var(--color-neo-accent);">
                    <label for="permission_{{ $permission->id }}" class="ml-2 text-sm" style="color: var(--color-neo-text);">
                        {{ ucfirst(explode('.', $permission->name)[1] ?? $permission->name) }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex gap-4">
            <button type="submit" class="neo-button-primary px-6 py-2 text-sm font-medium">Save Permissions</button>
            <a href="{{ route('admin.permissions.index') }}" class="neo-button px-6 py-2 text-sm font-medium" style="color: var(--color-neo-text);">Cancel</a>
        </div>
    </form>
</div>
@endsection

