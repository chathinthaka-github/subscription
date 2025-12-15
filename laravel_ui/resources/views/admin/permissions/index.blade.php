@extends('layouts.app')

@section('title', 'Manage Permissions by Role')

@section('content')
<div class="neo-card p-6 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: var(--color-neo-text);">Manage Permissions by Role</h1>
            <p class="mt-1 text-sm" style="color: var(--color-neo-text-light);">Select a role to manage its permissions</p>
        </div>
    </div>

    <div class="mt-8">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse($roles as $role)
            <div class="neo-card p-6 rounded-xl">
                <h3 class="text-lg font-semibold mb-2" style="color: var(--color-neo-text);">{{ ucfirst($role->name) }}</h3>
                <div class="space-y-2 mb-4">
                    <p class="text-sm" style="color: var(--color-neo-text-light);">
                        <span class="font-medium">{{ $role->permissions_count }}</span> permissions assigned
                    </p>
                    <p class="text-sm" style="color: var(--color-neo-text-light);">
                        <span class="font-medium">{{ $role->users_count }}</span> users with this role
                    </p>
                </div>
                @can('admin.update')
                <a href="{{ route('admin.permissions.show', $role) }}" class="neo-button-primary px-4 py-2 text-sm font-medium inline-flex items-center w-full justify-center">
                    Manage Permissions
                </a>
                @endcan
            </div>
            @empty
            <div class="col-span-full">
                <p class="text-sm text-center" style="color: var(--color-neo-text-light);">No roles found</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
