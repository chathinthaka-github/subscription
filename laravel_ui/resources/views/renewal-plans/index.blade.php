@extends('layouts.app')

@section('title', 'Renewal Plans')

@section('content')
<div class="px-4 sm:px-6 lg:px-8" style="background: #fff;">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold" style="color: #000;">Renewal Plans</h1>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            @can('renewal_plan.create')
            <a href="{{ route('renewal-plans.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">Add Plan</a>
            @endcan
        </div>
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
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Name</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold" style="color: #000; border-color: #000;">Type</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="border-color: #000;">
                        @forelse($plans as $plan)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0" style="color: #000;">{{ $plan->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $plan->service->shortcode->shortcode }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $plan->service->keyword }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ $plan->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm" style="color: #000;">{{ ucfirst($plan->plan_type) }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <div class="flex gap-2">
                                    @can('renewal_plan.update')
                                    <a href="{{ route('renewal-plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan
                                    @can('renewal_plan.delete')
                                    <form method="POST" action="{{ route('renewal-plans.destroy', $plan) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
                            <td colspan="6" class="py-4 text-center text-sm" style="color: #000;">No plans found</td>
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

