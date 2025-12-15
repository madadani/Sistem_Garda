@extends('layouts.app')

@section('title', 'Management Pasien')
@section('page-title', 'Management Pasien')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Pasien</h2>
            <p class="text-gray-600 text-sm mt-1">Riwayat pasien yang diantar driver</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" action="{{ route('patient.index') }}" class="space-y-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pasien atau keluhan..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>
                <div class="w-full sm:w-48">
                    <select name="destination" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="ALL">Semua Tujuan</option>
                        <option value="IGD" {{ request('destination') === 'IGD' ? 'selected' : '' }}>IGD</option>
                        <option value="Ponek" {{ request('destination') === 'Ponek' ? 'selected' : '' }}>Ponek</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    Cari
                </button>
                @if(request('search') || request('destination'))
                <a href="{{ route('patient.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Grafik Data Pasien -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Diagram Batangan Pasien Per Bulan -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Data Pasien Per Bulan</h3>
                <div class="text-sm text-gray-500">
                    <span id="current-year" class="font-medium"></span>
                </div>
            </div>
            
            <div class="relative h-64">
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
            
            <div class="relative h-64">
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

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan/Diagnosis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kedatangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $index => $patient)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $patients->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-mono font-medium text-gray-900">{{ $patient->transaction->transaction_id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $patient->patient_name ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $patient->patient_condition }}">
                                {{ $patient->patient_condition ?: '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($patient->destination === 'IGD')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                IGD
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Ponek
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-xs mr-2">
                                    {{ strtoupper(substr($patient->transaction->driver->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->transaction->driver->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $patient->arrival_time->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('patient.show', $patient) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('patient.edit', $patient) }}" class="text-green-600 hover:text-green-800 transition-colors" title="Edit Pasien">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('patient.destroy', $patient) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Hapus Pasien">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <p class="text-lg font-medium">Tidak ada data pasien</p>
                                <p class="text-sm mt-1">Belum ada pasien yang terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($patients->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Diagram Batangan Pasien Per Bulan
    let monthlyPatientChart = null;
    
    function initMonthlyPatientChart() {
        const ctx = document.getElementById('monthlyPatientChart').getContext('2d');
        
        monthlyPatientChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: [],
                    backgroundColor: 'rgba(147, 51, 234, 0.8)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1,
                    borderRadius: 6,
                    hoverBackgroundColor: 'rgba(147, 51, 234, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(147, 51, 234)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return `Pasien: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });
        
        loadMonthlyPatientData();
    }
    
    function loadMonthlyPatientData() {
        fetch('/dashboard/monthly-patient-data')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    monthlyPatientChart.data.labels = data.labels;
                    monthlyPatientChart.data.datasets[0].data = data.data;
                    monthlyPatientChart.update();
                    
                    // Update year and total
                    document.getElementById('current-year').textContent = data.year;
                    document.getElementById('yearly-total').textContent = data.data.reduce((a, b) => a + b, 0);
                }
            })
            .catch(error => {
                console.error('Error loading monthly patient data:', error);
            });
    }
    
    // Diagram Lingkaran Tujuan Pasien
    let destinationChart = null;
    
    function initDestinationChart() {
        const ctx = document.getElementById('destinationChart').getContext('2d');
        
        destinationChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',  // Red for IGD
                        'rgba(236, 72, 153, 0.8)' // Pink for Ponek
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(236, 72, 153)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(147, 51, 234)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        loadDestinationData();
    }
    
    function loadDestinationData() {
        fetch('/dashboard/patient-destination-data')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    destinationChart.data.labels = data.labels;
                    destinationChart.data.datasets[0].data = data.data;
                    destinationChart.update();
                    
                    // Update totals and percentages
                    document.getElementById('destination-total').textContent = data.total;
                    document.getElementById('igd-percentage').textContent = data.percentages.igd + '%';
                    document.getElementById('ponek-percentage').textContent = data.percentages.ponek + '%';
                }
            })
            .catch(error => {
                console.error('Error loading destination data:', error);
            });
    }
    
    // Initialize charts when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initMonthlyPatientChart();
        initDestinationChart();
    });
</script>
@endpush
