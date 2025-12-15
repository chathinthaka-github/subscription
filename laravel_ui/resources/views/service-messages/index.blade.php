@extends('layouts.app')

@section('title', 'Service Messages')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold" style="color: var(--color-neo-text);">Service Messages</h1>
            <p class="mt-2 text-sm" style="color: var(--color-neo-text-light);">Manage messages for each service</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('service_message.create')
            <a href="{{ route('service-messages.create') }}" class="neo-button-primary px-4 py-2 text-sm font-medium inline-flex items-center">Add Message</a>
            @endcan
        </div>
    </div>

    <div class="mt-4 mb-6">
        <form method="GET" action="{{ route('service-messages.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="shortcode_id" class="neo-input px-4 py-2" style="color: var(--color-neo-text);">
                <option value="">All Shortcodes</option>
                @foreach($shortcodes as $shortcode)
                    <option value="{{ $shortcode->id }}" {{ request('shortcode_id') == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="neo-input px-4 py-2" style="color: var(--color-neo-text);">
            <button type="submit" class="neo-button-primary px-4 py-2 text-sm font-medium">Search</button>
        </form>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: var(--color-neo-text);">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Shortcode</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Keyword</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Message</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($messages as $message)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $message->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $message->service->shortcode->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $message->service->keyword }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $message->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $message->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $message->message_type }}</td>
                            <td class="px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ Str::limit($message->message, 50) }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2 justify-end">
                                    @can('service_message.update')
                                    <a href="{{ route('service-messages.edit', $message) }}" class="neo-button px-3 py-1 text-sm" style="color: var(--color-neo-accent); font-weight: 600;">Edit</a>
                                    @endcan
                                    @can('service_message.delete')
                                    <form method="POST" action="{{ route('service-messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="neo-button-danger px-3 py-1 text-sm">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No messages found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection

