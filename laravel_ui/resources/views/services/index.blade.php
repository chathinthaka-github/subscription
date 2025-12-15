@extends('layouts.app')

@section('title', 'Services')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Services</h1>
        <p class="mt-1 text-sm text-gray-500">Manage your subscription services</p>
    </div>
    @can('service.create')
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('services.create') }}" class="neo-button-primary inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Service
        </a>
    </div>
    @endcan
</div>

<!-- Search -->
<div class="mb-6">
    <form method="GET" action="{{ route('services.index') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by shortcode or keyword..." class="neo-input max-w-md">
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
                    <th>Keyword</th>
                    <th>Status</th>
                    <th>FPMT</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td class="font-medium text-gray-900">{{ $service->id }}</td>
                    <td class="font-mono">{{ $service->shortcode->shortcode ?? '-' }}</td>
                    <td>{{ $service->keyword }}</td>
                    <td>
                        <span class="badge {{ $service->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </td>
                    <td>
                        @if($service->fpmt_enabled)
                            <span class="badge badge-info">Enabled</span>
                        @else
                            <span class="badge badge-secondary">Disabled</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex gap-2 justify-end">
                            @can('service.update')
                            <a href="{{ route('services.edit', $service) }}" class="neo-button text-xs px-3 py-1.5">Edit</a>
                            @endcan
                            @can('service.delete')
                            <form method="POST" action="{{ route('services.destroy', $service) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-gray-500">No services found</p>
                        @can('service.create')
                        <a href="{{ route('services.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Create your first service</a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($services->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $services->links() }}
    </div>
    @endif
</div>
@endsection
