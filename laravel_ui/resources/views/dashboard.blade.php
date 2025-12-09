@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <div class="mb-2">
        <h1 class="text-3xl font-bold" style="color: var(--color-neo-text);">Dashboard</h1>
        <p class="mt-2 text-base" style="color: var(--color-neo-text-light);">Overview of your subscription management system</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="neo-card p-6 rounded-2xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="neo-raised p-3 rounded-xl inline-block">
                    <svg class="h-6 w-6" style="color: var(--color-neo-accent);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 flex-1">
                <dl>
                    <dt class="text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Total Subscriptions</dt>
                    <dd class="text-2xl font-bold" style="color: var(--color-neo-text);">{{ $totalSubscriptions }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="neo-card p-6 rounded-2xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="neo-raised p-3 rounded-xl inline-block">
                    <svg class="h-6 w-6" style="color: var(--color-neo-success);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 flex-1">
                <dl>
                    <dt class="text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Active Subscriptions</dt>
                    <dd class="text-2xl font-bold" style="color: var(--color-neo-text);">{{ $activeSubscriptions }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="neo-card p-6 rounded-2xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="neo-raised p-3 rounded-xl inline-block">
                    <svg class="h-6 w-6" style="color: var(--color-neo-accent);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 flex-1">
                <dl>
                    <dt class="text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Active Services</dt>
                    <dd class="text-2xl font-bold" style="color: var(--color-neo-text);">{{ $totalServices }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="neo-card p-6 rounded-2xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="neo-raised p-3 rounded-xl inline-block">
                    <svg class="h-6 w-6" style="color: var(--color-neo-accent);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="ml-5 flex-1">
                <dl>
                    <dt class="text-sm font-medium mb-1" style="color: var(--color-neo-text-light);">Total MTs</dt>
                    <dd class="text-2xl font-bold" style="color: var(--color-neo-text);">{{ $totalMts }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="mt-8">
    <h2 class="text-2xl font-semibold mb-6" style="color: var(--color-neo-text);">Subscription Trends (Last 30 Days)</h2>
    <div class="neo-card p-8 rounded-2xl">
        <canvas id="subscriptionChart" width="400" height="100"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('subscriptionChart').getContext('2d');
    const subscriptionData = @json($subscriptionTrends);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: subscriptionData.map(item => item.date),
            datasets: [{
                label: 'Subscriptions',
                data: subscriptionData.map(item => item.count),
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection

