@extends('layouts.app')

@section('title', 'Shortcodes')

@section('content')
<div class="neo-card p-6 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: var(--color-neo-text);">Shortcodes</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('service.create')
            <a href="{{ route('shortcodes.create') }}" class="neo-button-primary px-4 py-2 text-sm font-medium inline-flex items-center">Add Shortcode</a>
            @endcan
        </div>
    </div>

    <div class="mt-4 mb-6">
        <form method="GET" action="{{ route('shortcodes.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by shortcode or description..." class="neo-input px-4 py-2 w-full max-w-md" style="color: var(--color-neo-text);">
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
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Description</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Services</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($shortcodes as $shortcode)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $shortcode->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $shortcode->shortcode }}</td>
                            <td class="px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $shortcode->description ?? '-' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $shortcode->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $shortcode->status }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $shortcode->services_count }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2 justify-end">
                                    @can('service.update')
                                    <a href="{{ route('shortcodes.edit', $shortcode) }}" class="neo-button px-3 py-1 text-sm" style="color: var(--color-neo-accent); font-weight: 600;">Edit</a>
                                    @endcan
                                    @can('service.delete')
                                    <form method="POST" action="{{ route('shortcodes.destroy', $shortcode) }}" class="inline" onsubmit="return confirm('Are you sure? This will fail if there are associated services.')">
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
                            <td colspan="6" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No shortcodes found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $shortcodes->links() }}
    </div>
</div>
@endsection

