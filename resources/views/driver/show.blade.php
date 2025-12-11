@extends('layouts.app')

@section('title', 'Detail Driver')
@section('page-title', 'Detail Driver')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('driver.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Driver
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Driver Info Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-8">
                    <div class="flex items-center">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-primary-600 font-bold text-2xl mr-4">
                            {{ strtoupper(substr($driver->name, 0, 2)) }}
                        </div>
                        <div class="text-white">
                            <h2 class="text-2xl font-bold">{{ $driver->name }}</h2>
                            <p class="text-primary-100 mt-1">ID: {{ $driver->driver_id_card }}</p>
                        </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">ID Card Driver</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $driver->driver_id_card }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $driver->name }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nomor Telepon</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $driver->phone_number }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500">Instansi</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $driver->instansi }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Total Poin</label>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-lg font-bold bg-yellow-100 text-yellow-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ number_format($driver->total_points) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Terdaftar Sejak</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $driver->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $driver->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <a href="{{ route('driver.qrcode.single', $driver) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-teal-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        Print QR Code
                    </a>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('driver.edit', $driver) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Driver
                        </a>
                        <form action="{{ route('driver.destroy', $driver) }}" method="POST" class="inline" onsubmit="confirmDelete(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Driver
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="space-y-6">
            <!-- QR Code & Point Page -->
            <div class="bg-gradient-to-br from-primary-500 to-purple-600 rounded-xl shadow-md p-6 text-white">
                <h3 class="text-lg font-semibold mb-2 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Barcode & QR Code
                </h3>
                <p class="text-xs text-primary-100 mb-4">Driver memiliki 2 jenis kode berbeda</p>
                
                <div class="space-y-3 mb-4">
                    <!-- Barcode Info -->
                    <div class="bg-primary-700 bg-opacity-50 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 bg-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-xs">1D</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm mb-1">📊 Barcode Scan (Batangan)</p>
                                <p class="text-xs text-primary-100">Untuk scan saat bawa pasien ke RS. Otomatis mencatat transaksi dan menunggu konfirmasi admin untuk dapat poin.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- QR Code Info -->
                    <div class="bg-primary-700 bg-opacity-50 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-xs">2D</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-sm mb-1">🎯 QR Code Poin</p>
                                <p class="text-xs text-primary-100">Untuk cek total poin saja. Tidak mencatat transaksi baru, hanya menampilkan poin yang dimiliki.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4 mb-4">
                    <div id="qrcode" class="flex justify-center"></div>
                    <p class="text-center text-xs text-gray-500 mt-2">Preview QR Code Poin</p>
                </div>
                
                <a href="{{ route('driver.qrcode.single', $driver) }}" target="_blank" class="block w-full text-center px-4 py-2.5 bg-white text-primary-600 font-semibold rounded-lg hover:bg-primary-50 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Lihat & Print Semua Barcode
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Poin Didapat</p>
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($driver->total_points) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-yellow-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Poin Sudah Ditukarkan</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ number_format($driver->points_redeemed ?? 0) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Sisa Poin Bisa Ditukar</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($driver->total_points - ($driver->points_redeemed ?? 0)) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="text-lg font-bold text-green-600">Aktif</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Member Since</p>
                                <p class="text-sm font-semibold text-purple-600">{{ $driver->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
// Generate QR Code
new QRCode(document.getElementById("qrcode"), {
    text: "{{ route('driver.point', $driver->driver_id_card) }}",
    width: 200,
    height: 200,
    colorDark: "#6366f1",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});
</script>
@endsection
