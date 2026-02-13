@extends('layouts.admin')

@section('title', 'Ad Analytics: ' . $ad->name)
@section('page-title', 'Ad Analytics')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $ad->name }}</h2>
        <p class="text-gray-600 mt-1">{{ str_replace('_', ' ', ucfirst($ad->position)) }} • {{ ucfirst($ad->type) }}</p>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" class="flex items-center gap-2">
            <select name="range" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="7" {{ $dateRange == 7 ? 'selected' : '' }}>Last 7 Days</option>
                <option value="30" {{ $dateRange == 30 ? 'selected' : '' }}>Last 30 Days</option>
                <option value="90" {{ $dateRange == 90 ? 'selected' : '' }}>Last 90 Days</option>
            </select>
        </form>
        <a href="{{ route('admin.ads.analytics.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all font-medium shadow-sm">
            Back to Analytics
        </a>
    </div>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium mb-1">Impressions</p>
                <h3 class="text-3xl font-bold">{{ number_format($summary['impressions']) }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium mb-1">Clicks</p>
                <h3 class="text-3xl font-bold">{{ number_format($summary['clicks']) }}</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium mb-1">CTR</p>
                <h3 class="text-3xl font-bold">{{ $summary['ctr'] }}%</h3>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Daily Performance Chart -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Daily Performance</h3>
    </div>
    <div class="p-6">
        <canvas id="dailyChart" height="80"></canvas>
    </div>
</div>

<!-- Device & Browser Breakdown -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Device Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Device Breakdown</h3>
        </div>
        <div class="p-6">
            <canvas id="deviceChart"></canvas>
        </div>
    </div>

    <!-- Browser Breakdown -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Top Browsers</h3>
        </div>
        <div class="p-6">
            @forelse($browserBreakdown as $browser)
            <div class="flex items-center justify-between {{ !$loop->last ? 'mb-3 pb-3 border-b border-gray-100' : '' }}">
                <span class="text-sm text-gray-700">{{ $browser->browser ?? 'Unknown' }}</span>
                <span class="text-sm font-semibold text-gray-900">{{ number_format($browser->count) }}</span>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500">No data available</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Hourly Distribution -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Hourly Distribution</h3>
    </div>
    <div class="p-6">
        <canvas id="hourlyChart" height="60"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Performance Chart
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyStats = @json($dailyStats);
    
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: dailyStats.map(d => d.date),
            datasets: [
                {
                    label: 'Impressions',
                    data: dailyStats.map(d => d.impressions),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Clicks',
                    data: dailyStats.map(d => d.clicks),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // Device Chart
    const deviceCtx = document.getElementById('deviceChart').getContext('2d');
    const deviceData = @json($deviceBreakdown);
    
    new Chart(deviceCtx, {
        type: 'doughnut',
        data: {
            labels: deviceData.map(d => d.device_type || 'Unknown'),
            datasets: [{
                data: deviceData.map(d => d.count),
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(251, 146, 60)',
                    'rgb(168, 85, 247)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Hourly Chart
    const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
    const hourlyStats = @json($hourlyStats);
    
    // Fill missing hours with 0
    const hours = Array.from({length: 24}, (_, i) => i);
    const hourlyData = hours.map(hour => {
        const stat = hourlyStats.find(s => s.hour == hour);
        return {
            hour: hour,
            impressions: stat ? stat.impressions : 0,
            clicks: stat ? stat.clicks : 0
        };
    });
    
    new Chart(hourlyCtx, {
        type: 'bar',
        data: {
            labels: hourlyData.map(d => d.hour + ':00'),
            datasets: [
                {
                    label: 'Impressions',
                    data: hourlyData.map(d => d.impressions),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                },
                {
                    label: 'Clicks',
                    data: hourlyData.map(d => d.clicks),
                    backgroundColor: 'rgba(34, 197, 94, 0.5)',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
</script>
@endpush
@endsection
