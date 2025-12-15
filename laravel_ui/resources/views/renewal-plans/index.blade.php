@extends('layouts.app')

@section('title', 'Renewal Plans')

@section('content')
<div class="neo-card p-8 rounded-2xl">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-semibold" style="color: var(--color-neo-text);">Renewal Plans</h1>
            <p class="mt-2 text-sm" style="color: var(--color-neo-text-light);">Manage renewal plans for services</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('renewal_plan.create')
            <a href="{{ route('renewal-plans.create') }}" class="neo-button-primary px-4 py-2 text-sm font-medium inline-flex items-center">Add Plan</a>
            @endcan
        </div>
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
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Name</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Type</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: var(--color-neo-text);">Price</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: rgba(163, 163, 163, 0.1);">
                        @forelse($plans as $plan)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: var(--color-neo-text);">{{ $plan->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $plan->service->shortcode->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $plan->service->keyword }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $plan->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ ucfirst($plan->plan_type) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: var(--color-neo-text-light);">{{ $plan->price_code }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2 justify-end">
                                    @can('renewal_plan.update')
                                    <a href="{{ route('renewal-plans.edit', $plan) }}" class="neo-button px-3 py-1 text-sm" style="color: var(--color-neo-accent); font-weight: 600;">Edit</a>
                                    @endcan
                                    @can('renewal_plan.delete')
                                    <form method="POST" action="{{ route('renewal-plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
                            <td colspan="7" class="py-4 text-center text-sm" style="color: var(--color-neo-text-light);">No plans found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $plans->links() }}
    </div>
</div>
@endsection

