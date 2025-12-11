@extends('layouts.public')

@section('title', 'Total Poin Driver')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-500 via-purple-600 to-pink-500 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <!-- Success Animation Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header dengan Checkmark Animation -->
            <div class="bg-gradient-to-r from-primary-500 to-purple-600 p-4 text-center">
                <div class="mb-4 flex justify-center">
                    <div class="w-13 h-13 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Total Poin Driver</h1>
                <p class="text-primary-100">Sistem Reward GARDA</p>
            </div>

            <!-- Driver Info -->
            <div class="p-5">
                <div class="text-center mb-5">
                    <!-- <div class="w-24 h-24 mx-auto bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                        <span class="text-white font-bold text-3xl">{{ strtoupper(substr($driver->name, 0, 2)) }}</span> -->
                    <!-- </div> --> 
                    <h2 class="text-3x3 font-bold text-gray-800 mb-2">{{ $driver->name }}</h2>
                    <p class="text-gray-500 font-mono text-lg">{{ $driver->driver_id_card }}</p>
                    <!-- <p class="text-gray-600 text-sm mt-1">{{ $driver->phone_number }}</p> -->
                </div>

                <!-- Points Summary -->
                <div class="">
                    <div class="text-center">
                        <div class="flex items-center justify-center space-x-6 mb-4">
                            <div class="text-center">
                                <div class="text-2x1 font-bold text-primary-700 flex items-center justify-center">
                                    <span class="mr-1">{{ number_format($driver->total_points) }}</span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/1476/1476702.png" 
                                         alt="Poin" 
                                         class="w-6 h-6 ml-1">
                                </div>
                                <div class="text-sm text-white-500">Total Poin</div>
                            </div>
                            <!-- <div class="h-12 w-px bg-gray-200"></div>
                            <div class="text-center">
                                <div class="text-4xl font-bold text-green-600">{{ $driver->total_confirmed_transactions }}</div>
                                <div class="text-xs text-gray-500">Total Pasien</div>
                            </div> -->
                        </div>
                        <!-- <p class="text-gray-500 text-xs mt-3">Setiap pasien yang diantar mendapatkan 1 poin</p> -->
                    </div>
                </div>

                <!-- Daftar Riwayat Pengantaran -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat Pengantaran
                    </h3>
                    
                    @if($transactions && count($transactions) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poin</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transactions as $key => $transaction)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaction->patient->patient_name ?? 'Nama Pasien Tidak Tersedia' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            @if($transaction->patient && $transaction->patient->destination)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span>{{ $transaction->patient->destination == 'IGD' ? 'IGD' : 'PONEK' }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ $transaction->scan_time->translatedFormat('l, d F Y H:i') }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            @if($transaction->patient)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    +1 Poin
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($transactions->hasPages())
                            <div class="mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat pengantaran</h3>
                            <p class="mt-1 text-sm text-gray-500">Riwayat pengantaran akan muncul di sini</p>
                        </div>
                    @endif
                </div>

                <!-- Status Info -->
                @if($latestTransaction)
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-blue-800 font-medium">Transaksi Terakhir:</p>
                            <p class="text-xs text-blue-600 mt-1">{{ $latestTransaction->scan_time->diffForHumans() }}</p>
                            <p class="text-xs text-blue-600 mt-1">
                                Status: 
                                @if($latestTransaction->status === 'PENDING')
                                <span class="font-semibold">⏳ Menunggu Konfirmasi</span>
                                @elseif($latestTransaction->status === 'CONFIRMED')
                                <span class="font-semibold text-green-600">✅ Dikonfirmasi</span>
                                @else
                                <span class="font-semibold text-red-600">❌ Ditolak</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Belum ada transaksi</p>
                        <p class="text-xs text-gray-500 mt-1">Scan barcode saat bawa pasien untuk mencatat transaksi</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6">
            <p class="text-white text-sm drop-shadow-lg">
                Scan QR ini hanya untuk melihat poin 💰
            </p>
            <p class="text-white text-xs drop-shadow mt-1 opacity-75">
                Untuk mencatat transaksi, scan barcode saat bawa pasien
            </p>
        </div>
    </div>
</div>

<style>
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bg-white {
    animation: slideInUp 0.5s ease-out;
}
</style>
@endsection
