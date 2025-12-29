@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    @keyframes pulse-grow {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .pulse-animation {
        animation: pulse-grow 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-2xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-2">@php
                    $hour = now()->hour;
                    switch (true) {
                        case ($hour < 12):
                            $greeting = 'Pagi';
                            break;
                        case ($hour < 15):
                            $greeting = 'Siang';
                            break;
                        case ($hour < 18):
                            $greeting = 'Sore';
                            break;
                        default:
                            $greeting = 'Malam';
                    }
                @endphp
                Selamat {{ $greeting }}, {{ Auth::user()->name }}! 👋</h2>
            </div>
            <div class="hidden md:block">
                <svg class="w-32 h-32 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Driver -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Driver</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalDrivers }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">+{{ $newDriversToday }}</span>
                <span class="text-sm text-gray-500">hari ini</span>
            </div>
        </div>
        
        <!-- Total Pasien -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Pasien</p>
                    <p id="total-patients" class="text-3xl font-bold text-gray-800">{{ $totalPatients }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span id="new-patients-today" class="text-sm text-green-600 font-medium">+{{ $newPatientsToday }}</span>
                <span class="text-sm text-gray-500">pasien baru</span>
            </div>
        </div>
        
        <!-- Scan Hari Ini -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Scan Hari Ini</p>
                    <div class="flex items-baseline space-x-2">
                        <p id="scans-today" class="text-3xl font-bold text-gray-800">{{ $scansToday }}</p>
                        <span id="new-scan-badge" class="hidden bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">+1</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @php
                    $yesterday = now()->subDay()->startOfDay();
                    $scansYesterday = \App\Models\Transaction::whereDate('scan_time', $yesterday)->count();
                    $percentageChange = $scansYesterday > 0 ? round((($scansToday - $scansYesterday) / $scansYesterday) * 100) : 0;
                @endphp
                <span id="scan-change" class="text-sm {{ $percentageChange >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                    {{ $percentageChange >= 0 ? '↑' : '↓' }} {{ abs($percentageChange) }}%
                </span>
                <span class="text-sm text-gray-500">dari kemarin</span>
            </div>
        </div>
        
        <!-- Total Poin -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Poin</p>
                    <p id="total-points" class="text-3xl font-bold text-gray-800">{{ number_format($totalPoints) }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                @php
                    $pointsIncrease = $totalPoints - ($totalPointsYesterday ?? 0);
                    $pointsPercentage = ($totalPointsYesterday ?? 0) > 0 ? round(($pointsIncrease / $totalPointsYesterday) * 100) : 0;
                @endphp
                <span id="points-change" class="text-sm {{ $pointsIncrease >= 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                    {{ $pointsIncrease >= 0 ? '↑' : '↓' }} {{ abs($pointsPercentage) }}%
                </span>
                <span class="text-sm text-gray-500">dari kemarin</span>
            </div>
        </div>
    </div>
    </div>
    </div>
    
    <!-- Grafik Data Pasien -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Diagram Batangan Pasien Per Bulan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Data Pasien Per Bulan</h3>
                <div class="text-sm text-gray-500">
                    <span id="current-year" class="font-medium"></span>
                </div>
            </div>
            
            <div class="relative h-80">
                <canvas id="monthlyPatientChart"></canvas>
            </div>
            
            <div class="mt-4 text-center">
                <span class="text-sm text-gray-500">Total pasien tahun ini: </span>
                <span id="yearly-total" class="text-sm font-semibold text-gray-800"></span>
                <span class="text-sm text-gray-500"> pasien</span>
            </div>
        </div>

        <!-- Diagram Lingkaran Tujuan Pasien -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Distribusi Tujuan Pasien</h3>
                <div class="text-sm text-gray-500">
                    Total: <span id="destination-total" class="font-medium"></span>
                </div>
            </div>
            
            <div class="relative h-80">
                <canvas id="destinationChart"></canvas>
            </div>
            
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div class="flex items-center justify-center">
                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">IGD: </span>
                    <span id="igd-percentage" class="text-sm font-semibold text-gray-800 ml-1"></span>
                </div>
                <div class="flex items-center justify-center">
                    <div class="w-3 h-3 bg-pink-500 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Ponek: </span>
                    <span id="ponek-percentage" class="text-sm font-semibold text-gray-800 ml-1"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
            <div id="recent-activities-container" class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="flex items-start space-x-3 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $activity['color'] }}">
                        {!! $activity['icon'] !!}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity['subtitle'] }} • {{ $activity['time'] }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada aktivitas terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('driver.index') }}" class="p-4 border-2 border-gray-200 rounded-xl hover:border-primary-500 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-primary-500 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">Tambah Driver</p>
                </a>
                
                <a href="{{ route('scan.index') }}" class="p-4 border-2 border-gray-200 rounded-xl hover:border-primary-500 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-primary-500 transition-colors">
                        <svg class="w-6 h-6 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">Data Scan</p>
                </a>
                
                <a href="{{ route('pasien.index') }}" class="p-4 border-2 border-gray-200 rounded-xl hover:border-primary-500 hover:bg-primary-50 transition-all group">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-primary-500 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">Lihat Pasien</p>
                </a>
                
                <button onclick="confirmResetPoints()" class="p-4 border-2 border-red-200 rounded-xl hover:border-red-500 hover:bg-red-50 transition-all group">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-red-500 transition-colors">
                        <svg class="w-6 h-6 text-red-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-800">Reset Data Sistem</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script>
    // Inject configuration from Laravel to JavaScript
    dashboardConfig = {
        routes: {
            monthlyPatientData: "{{ route('api.dashboard.monthly-patient-data') }}",
            patientDestinationData: "{{ route('api.dashboard.patient-destination-data') }}",
            scanCount: "{{ route('dashboard.scan-count') }}",
            patientCount: "{{ route('dashboard.patient-count') }}",
            pointsCount: "{{ route('dashboard.points-count') }}",
            resetPoints: "{{ route('dashboard.reset-points') }}"
        },
        initialData: {
            scansToday: {{ $scansToday }},
            totalPatients: {{ $totalPatients }},
            totalPoints: {{ $totalPoints }}
        },
        csrfToken: "{{ csrf_token() }}",
        pusherConfig: {
            key: "{{ config('broadcasting.connections.pusher.key') }}",
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}"
        }
    };
</script>
@endpush
