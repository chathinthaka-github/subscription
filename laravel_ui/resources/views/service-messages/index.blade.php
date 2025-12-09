@extends('layouts.app')

@section('title', 'Service Messages')

@section('content')
<div class="px-4 sm:px-6 lg:px-8" style="background: #fff;">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: #000;">Service Messages</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('service_message.create')
            <a href="{{ route('service-messages.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Add Message</a>
            @endcan
        </div>
    </div>

    <div class="mt-4 flex gap-4">
        <form method="GET" action="{{ route('service-messages.index') }}" class="flex gap-4 flex-1">
            <select name="shortcode_id" class="rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
                <option value="">All Shortcodes</option>
                @foreach($shortcodes as $shortcode)
                    <option value="{{ $shortcode->id }}" {{ request('shortcode_id') == $shortcode->id ? 'selected' : '' }}>{{ $shortcode->shortcode }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="flex-1 rounded-md border border-black shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" style="color: #000; background: #fff;">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Search</button>
        </form>
    </div>

    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y" style="border-color: #000;">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0" style="color: #000; border-color: #000;">ID</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Shortcode</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Keyword</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Message</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #000;">
                        @forelse($messages as $message)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: #000;">{{ $message->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $message->service->shortcode->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $message->service->keyword }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $message->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $message->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $message->message_type }}</td>
                            <td class="px-3 py-4 text-sm" style="color: #000;">{{ Str::limit($message->message, 50) }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2">
                                    @can('service_message.update')
                                    <a href="{{ route('service-messages.edit', $message) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan
                                    @can('service_message.delete')
                                    <form method="POST" action="{{ route('service-messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-sm" style="color: #000;">No messages found</td>
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

