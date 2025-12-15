@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500">Overview of your subscription management system</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Subscriptions -->
    <div class="neo-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Subscriptions</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalSubscriptions) }}</p>
            </div>
            <div class="neo-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">{{ $activeSubscriptions }}</span>
            <span class="text-gray-400 ml-1">active</span>
        </div>
    </div>
    
    <!-- Active Subscriptions -->
    <div class="neo-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Active Subscriptions</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($activeSubscriptions) }}</p>
            </div>
            <div class="neo-icon neo-icon-success">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            @php $rate = $totalSubscriptions > 0 ? round(($activeSubscriptions / $totalSubscriptions) * 100, 1) : 0; @endphp
            <span class="text-green-600 font-medium">{{ $rate }}%</span>
            <span class="text-gray-400 ml-1">of total</span>
        </div>
    </div>
    
    <!-- Active Services -->
    <div class="neo-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Active Services</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalServices) }}</p>
            </div>
            <div class="neo-icon neo-icon-secondary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-blue-600 font-medium">Running</span>
            <span class="text-gray-400 ml-1">smoothly</span>
        </div>
    </div>
    
    <!-- Total MTs -->
    <div class="neo-stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total MT Messages</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalMts) }}</p>
            </div>
            <div class="neo-icon neo-icon-warning">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-green-600 font-medium">{{ $successfulMts }}</span>
            <span class="text-gray-400 ml-1">successful</span>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Subscription Trends Chart -->
    <div class="chart-container">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Subscription Trends</h3>
            <span class="text-sm text-gray-500">Last 30 days</span>
        </div>
        <div style="height: 280px;">
            <canvas id="subscriptionChart"></canvas>
        </div>
    </div>
    
    <!-- MT Status Distribution -->
    <div class="chart-container">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">MT Status Distribution</h3>
            <span class="text-sm text-gray-500">All time</span>
        </div>
        <div style="height: 280px;">
            <canvas id="mtStatusChart"></canvas>
        </div>
    </div>
</div>

<!-- Bottom Row Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Renewal Jobs Status -->
    <div class="chart-container">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Renewal Jobs</h3>
            <span class="badge badge-info">{{ $totalRenewalJobs }} total</span>
        </div>
        <div style="height: 220px;">
            <canvas id="renewalJobsChart"></canvas>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="chart-container lg:col-span-2">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">System Overview</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">{{ $totalSubscriptions }}</p>
                <p class="text-xs text-gray-500 mt-1">Subscriptions</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-green-600">{{ $successfulMts }}</p>
                <p class="text-xs text-gray-500 mt-1">Successful MTs</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-purple-600">{{ $totalRenewalJobs }}</p>
                <p class="text-xs text-gray-500 mt-1">Renewal Jobs</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-amber-600">{{ $totalServices }}</p>
                <p class="text-xs text-gray-500 mt-1">Active Services</p>
            </div>
        </div>
        
        <!-- Recent Activity Placeholder -->
        <div class="mt-6">
            <h4 class="text-sm font-medium text-gray-700 mb-3">System Health</h4>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Subscription Rate</span>
                    <div class="flex items-center gap-2">
                        <div class="w-32 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ $rate }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $rate }}%</span>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">MT Success Rate</span>
                    @php $mtRate = $totalMts > 0 ? round(($successfulMts / $totalMts) * 100, 1) : 0; @endphp
                    <div class="flex items-center gap-2">
                        <div class="w-32 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ $mtRate }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $mtRate }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js defaults for consistent styling
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#64748B';
    
    // Subscription Trends Line Chart
    const subscriptionData = @json($subscriptionTrends);
    new Chart(document.getElementById('subscriptionChart'), {
        type: 'line',
        data: {
            labels: subscriptionData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            }),
            datasets: [{
                label: 'Subscriptions',
                data: subscriptionData.map(item => item.count),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#3B82F6',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { maxTicksLimit: 7 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { precision: 0 }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    
    // MT Status Doughnut Chart
    const mtStatusData = @json($mtStatusDistribution);
    new Chart(document.getElementById('mtStatusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(mtStatusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: Object.values(mtStatusData),
                backgroundColor: ['#10B981', '#EF4444', '#F59E0B', '#6B7280'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
    
    // Renewal Jobs Bar Chart
    const renewalData = @json($renewalJobsByStatus);
    new Chart(document.getElementById('renewalJobsChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(renewalData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: Object.values(renewalData),
                backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
                borderRadius: 6,
                barThickness: 32
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endsection
