@extends('layouts.app')

@section('title', 'Reward')
@section('page-title', 'Reward')

@section('content')
    <div class="space-y-6">
        <!-- Alert Messages -->
        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" id="success-alert">
                {{ $message }}
                <button type="button" class="float-right text-green-700" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" id="error-alert">
                {{ $message }}
                <button type="button" class="float-right text-red-700" onclick="this.parentElement.style.display='none'">
                    &times;
                </button>
            </div>
        @endif

        <!-- Filter & Export Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
                <form action="{{ route('reward.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                            <select name="month" id="month"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                            <select name="year" id="year"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Semua Tahun</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = $currentYear - 4;
                                @endphp
                                @foreach(range($currentYear, $startYear) as $y)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Filter
                        </button>
                        <a href="{{ route('reward.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Export Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ekspor Laporan Poin Driver</h3>

                <div class="space-y-4">
                    <!-- Export Semua Driver -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Ekspor Semua Driver</h4>
                        <div class="space-y-4">
                            <a href="{{ route('reward.export-all', ['month' => $selectedMonth, 'year' => $selectedYear]) }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors shadow-md hover:shadow-lg transform hover:scale-105"
                                onclick="showLoadingSpinner(this)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="font-medium">Ekspor Semua (Excel)</span>
                            </a>
                            <p class="text-xs text-gray-500">
                                Unduh data driver berdasarkan filter yang aktif
                                @if($selectedMonth || $selectedYear)
                                    ({{ $selectedMonth ? date('F', mktime(0, 0, 0, $selectedMonth, 1)) : '' }}
                                    {{ $selectedYear }})
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-800">
                        <strong>Info:</strong> Ekspor data poin dan riwayat transaksi driver dalam satu file Excel.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Reward (SUDAH DI-GROUP BERDASARKAN DRIVER) -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Reward (Per Driver)</h3>
                <div class="text-sm text-gray-500">
                    Total Driver Unik: {{ $rewards->count() }} data
                    @if($selectedMonth || $selectedYear)
                        terfilter ({{ $selectedMonth ? date('F', mktime(0, 0, 0, $selectedMonth, 1)) : '' }}
                        {{ $selectedYear }})
                    @endif
                </div>
            </div>

            @if($rewards->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                    Driver</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Instansi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                                    Poin </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status Terakhir</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl.
                                    Terakhir</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rewards as $key => $reward)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        <div class="font-medium text-gray-900">{{ $reward->driver_name ?? '-' }}</div>
                                        @if($reward->driver_id_card)
                                            <div class="text-xs text-gray-500">{{ $reward->driver_id_card }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                        {{ $reward->original_driver->instansi ?? '-' }}
                                    </td>
                                    {{-- MENAMPILKAN TOTAL POIN KELUAR --}}
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-bold">
                                        <span
                                            class="text-green-700">{{ number_format($reward->total_points_spent, 0, ',', '.') }}</span>
                                    </td>
                                    {{-- STATUS TERAKHIR --}}
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        @php
                                            $status = strtolower($reward->latest_status);
                                            $statusColors = [
                                                'completed' => ['bg' => 'green-100', 'text' => 'green-800'],
                                                'pending' => ['bg' => 'yellow-100', 'text' => 'yellow-800'],
                                                'rejected' => ['bg' => 'red-100', 'text' => 'red-800'],
                                            ];
                                            $color = $statusColors[$status] ?? $statusColors['pending'];
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-{{ $color['bg'] }} text-{{ $color['text'] }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    {{-- TANGGAL TRANSAKSI TERAKHIR --}}
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                        {{ $reward->latest_date->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('reward.export', ['driver_id' => $reward->id, 'month' => $selectedMonth, 'year' => $selectedYear]) }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700 transition-colors"
                                            onclick="showLoadingSpinner(this)">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Export
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Dihilangkan karena data sudah di-group menjadi Collection biasa, bukan LengthAwarePaginator. -->

            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg mb-2">Belum ada data reward untuk periode ini</p>
                    <p class="text-gray-400 text-sm">Silakan ganti filter atau tambahkan data reward baru.</p>
                </div>
            @endif
        </div>

        <!-- Inline JS: AJAX export, spinner, toasts -->
        <script>
            (function () {
                // Auto-hide alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('#success-alert, #error-alert');
                    alerts.forEach(alert => {
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    });
                }, 5000);

                // Function to show loading spinner for export buttons
                function showLoadingSpinner(button) {
                    const originalContent = button.innerHTML;
                    const isSmallButton = button.classList.contains('text-xs');
                    const iconSize = isSmallButton ? 'w-4 h-4' : 'w-5 h-5';

                    // Show spinner
                    button.innerHTML = `
                        <svg class="${iconSize} animate-spin" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        ${isSmallButton ? '' : 'Memproses...'}
                    `;
                    button.style.pointerEvents = 'none';
                    button.classList.add('opacity-75');

                    // Restore after 3 seconds (fallback)
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.style.pointerEvents = '';
                        button.classList.remove('opacity-75');
                    }, 3000);
                }

                function showToast(message, type) {
                    var container = document.getElementById('toastContainer');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'toastContainer';
                        container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
                        document.body.appendChild(container);
                    }

                    var el = document.createElement('div');
                    el.className = `px-4 py-3 rounded-lg shadow-lg flex items-center justify-between min-w-64 max-w-md ${type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
                            'bg-green-100 text-green-800 border border-green-200'
                        }`;

                    el.innerHTML = `
                        <span>${message}</span>
                        <button type="button" class="text-${type === 'error' ? 'red' : 'green'}-600 hover:text-${type === 'error' ? 'red' : 'green'}-800" onclick="this.parentElement.remove()">
                            &times;
                        </button>
                    `;

                    container.appendChild(el);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (el.parentElement) {
                            el.style.opacity = '0';
                            el.style.transition = 'opacity 0.5s';
                            setTimeout(() => el.remove(), 500);
                        }
                    }, 5000);
                }
            })();
        </script>
    </div>
@endsection