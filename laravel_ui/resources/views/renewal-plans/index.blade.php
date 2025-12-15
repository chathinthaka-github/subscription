@extends('layouts.app')

@section('title', 'Renewal Plans')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Renewal Plans</h1>
        <p class="mt-1 text-sm text-gray-500">Manage renewal schedules for your services</p>
    </div>
    @can('renewal_plan.create')
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('renewal-plans.create') }}" class="neo-button-primary inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Plan
        </a>
    </div>
    @endcan
</div>

<!-- Plans Table -->
<div class="neo-card overflow-hidden p-0">
    <div class="overflow-x-auto">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Shortcode</th>
                    <th>Keyword</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price Code</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                <tr>
                    <td class="font-medium text-gray-900">{{ $plan->id }}</td>
                    <td>{{ $plan->service->shortcode->shortcode }}</td>
                    <td>{{ $plan->service->keyword }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($plan->plan_type) }}</span>
                    </td>
                    <td>{{ $plan->price_code ?? '-' }}</td>
                    <td class="text-right">
                        <div class="flex gap-2 justify-end">
                            @can('renewal_plan.update')
                            <a href="{{ route('renewal-plans.edit', $plan) }}" class="neo-button text-xs px-3 py-1.5">Edit</a>
                            @endcan
                            @can('renewal_plan.delete')
                            <form method="POST" action="{{ route('renewal-plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-gray-500">No renewal plans found</p>
                        @can('renewal_plan.create')
                        <a href="{{ route('renewal-plans.create') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">Create your first plan</a>
                        @endcan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($plans->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $plans->links() }}
    </div>
    @endif
</div>
@endsection
