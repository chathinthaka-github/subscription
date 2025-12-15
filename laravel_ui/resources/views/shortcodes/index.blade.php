@extends('layouts.app')

@section('title', 'Shortcodes')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Shortcodes</h1>
        <p class="mt-1 text-sm text-gray-500">Manage your telecom shortcodes</p>
    </div>
    @can('service.create')
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('shortcodes.create') }}" class="neo-button-primary inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Shortcode
        </a>
    </div>
    @endcan
</div>

<!-- Search -->
<div class="mb-6">
    <form method="GET" action="{{ route('shortcodes.index') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by shortcode or description..." class="neo-input max-w-md">
        <button type="submit" class="neo-button-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search
        </button>
    </form>
</div>

<!-- Table -->
<div class="neo-card overflow-hidden p-0">
    <div class="overflow-x-auto">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shortcode</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Services</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shortcodes as $shortcode)
                <tr>
                    <td class="font-medium text-gray-900">{{ $shortcode->id }}</td>
                    <td class="font-mono">{{ $shortcode->shortcode }}</td>
                    <td>{{ $shortcode->description ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $shortcode->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($shortcode->status) }}
                        </span>
                    </td>
                    <td>{{ $shortcode->services_count }}</td>
                    <td class="text-right">
                        <div class="flex gap-2 justify-end">
                            @can('service.update')
                            <a href="{{ route('shortcodes.edit', $shortcode) }}" class="neo-button text-xs px-3 py-1.5">Edit</a>
                            @endcan
                            @can('service.delete')
                            <form method="POST" action="{{ route('shortcodes.destroy', $shortcode) }}" class="inline" onsubmit="return confirm('Are you sure? This will fail if there are associated services.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="neo-button-danger text-xs px-3 py-1.5">Delete</button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        <p class="text-gray-500">No shortcodes found</p>
                        @can('service.create')
                        <a href="{{ route('shortcodes.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Create your first shortcode</a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($shortcodes->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $shortcodes->links() }}
    </div>
    @endif
</div>
@endsection
