@extends('layouts.app')

@section('title', 'Shortcode Details')

@section('content')
<div class="neo-card p-6 rounded-2xl max-w-4xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: var(--color-neo-text);">Shortcode: {{ $shortcode->shortcode }}</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('service.update')
            <a href="{{ route('shortcodes.edit', $shortcode) }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Edit</a>
            @endcan
        </div>
    </div>

    <div class="space-y-4 mb-6">
        <div>
            <label class="block text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Description</label>
            <p class="text-sm" style="color: var(--color-neo-text);">{{ $shortcode->description ?? 'No description' }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Status</label>
            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $shortcode->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $shortcode->status }}
            </span>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-lg font-semibold mb-4" style="color: var(--color-neo-text);">Associated Services ({{ $shortcode->services->count() }})</h2>
        @if($shortcode->services->count() > 0)
        <div class="neo-card p-4 rounded-xl">
            <table class="min-w-full divide-y" style="border-color: rgba(163, 163, 163, 0.2);">
                <thead>
                    <tr>
                        <th class="py-2 text-left text-sm font-semibold" style="color: var(--color-neo-text);">ID</th>
                        <th class="py-2 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Keyword</th>
                        <th class="py-2 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Status</th>
                        <th class="py-2 text-left text-sm font-semibold" style="color: var(--color-neo-text);">FPMT</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                    @foreach($shortcode->services as $service)
                    <tr>
                        <td class="py-2 text-sm" style="color: var(--color-neo-text-light);">{{ $service->id }}</td>
                        <td class="py-2 text-sm" style="color: var(--color-neo-text-light);">{{ $service->keyword }}</td>
                        <td class="py-2 text-sm">
                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $service->status }}
                            </span>
                        </td>
                        <td class="py-2 text-sm" style="color: var(--color-neo-text-light);">{{ $service->fpmt_enabled ? 'Yes' : 'No' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm" style="color: var(--color-neo-text-light);">No services associated with this shortcode.</p>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('shortcodes.index') }}" class="neo-button px-4 py-2 text-sm font-medium inline-flex items-center" style="color: var(--color-neo-text);">Back to List</a>
    </div>
</div>
@endsection

