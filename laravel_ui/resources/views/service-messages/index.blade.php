@extends('layouts.app')

@section('title', 'Service Messages')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Service Messages</h1>
        <p class="mt-1 text-sm text-gray-500">Manage messages for each service</p>
    </div>
    @can('service_message.create')
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('service-messages.create') }}" class="neo-button-primary inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Message
        </a>
    </div>
    @endcan
</div>

<!-- Filters -->
<div class="mb-6">
    <form method="GET" action="{{ route('service-messages.index') }}" class="flex flex-wrap gap-3">
        <select name="shortcode_id" class="neo-input w-auto min-w-[180px]">
            <option value="">All Shortcodes</option>
            @foreach($shortcodes as $shortcode)
                <option value="{{ $shortcode->id }}" {{ request('shortcode_id') == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
            @endforeach
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..." class="neo-input max-w-xs">
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
                    <th>Type</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                <tr>
                    <td class="font-medium text-gray-900">{{ $message->id }}</td>
                    <td class="font-mono">{{ $message->service->shortcode->shortcode }}</td>
                    <td>{{ $message->service->keyword }}</td>
                    <td><span class="badge badge-info">{{ $message->message_type }}</span></td>
                    <td class="max-w-xs truncate">{{ Str::limit($message->message, 40) }}</td>
                    <td>
                        <span class="badge {{ $message->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($message->status) }}
                        </span>
                    </td>
                    <td class="text-right">
                        <div class="flex gap-2 justify-end">
                            @can('service_message.update')
                            <a href="{{ route('service-messages.edit', $message) }}" class="neo-button text-xs px-3 py-1.5">Edit</a>
                            @endcan
                            @can('service_message.delete')
                            <form method="POST" action="{{ route('service-messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="7" class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <p class="text-gray-500">No messages found</p>
                        @can('service_message.create')
                        <a href="{{ route('service-messages.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Create your first message</a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($messages->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
