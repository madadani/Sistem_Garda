@extends('layouts.app')

@section('title', 'Print QR Code Driver')
@section('page-title', 'Print QR Code Driver')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Barcode & QR Code Semua Driver</h2>
            <p class="text-gray-600 text-sm mt-1">Cetak barcode scan dan QR poin untuk semua driver</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('driver.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:from-primary-700 hover:to-purple-700 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Semua Barcode
            </button>
        </div>
    </div>

    <!-- QR Code Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 print:grid-cols-2">
        @foreach($drivers as $driver)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-gray-200 print:break-inside-avoid print:mb-4">
            <!-- Barcode Section (For Scanning Transaction) -->
            <div class="border-b-2 border-gray-200">
                <!-- Header -->
                <div class="bg-gradient-to-r from-pink-500 to-red-500 px-4 py-3 text-center">
                    <h3 class="text-white font-bold text-base">📊 BARCODE SCAN</h3>
                    <p class="text-pink-100 text-xs">Scan saat bawa pasien ke RS</p>
                </div>

                <!-- Driver Info -->
                <div class="p-4 text-center bg-gray-50">
                    <div class="w-14 h-14 mx-auto bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mb-2">
                        {{ strtoupper(substr($driver->name, 0, 2)) }}
                    </div>
                    <h4 class="font-bold text-gray-900 text-base">{{ $driver->name }}</h4>
                    <p class="text-xs text-gray-600 font-mono">{{ $driver->driver_id_card }}</p>
                </div>

                <!-- Barcode -->
                <div class="p-4 bg-white">
                    <div class="bg-gray-50 p-3 rounded-lg border-2 border-pink-500">
                        <svg class="barcode-container mx-auto" data-code="{{ $driver->driver_id_card }}"></svg>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-2">Untuk mencatat transaksi</p>
                </div>
            </div>

            <!-- QR Code Section (For Viewing Points) -->
            <div>
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-4 py-3 text-center">
                    <h3 class="text-white font-bold text-base">🎯 QR CODE POIN</h3>
                    <p class="text-primary-100 text-xs">Scan untuk lihat total poin</p>
                </div>

                <!-- QR Code -->
                <div class="p-4 bg-gray-50">
                    <div class="bg-white p-3 rounded-lg border-2 border-primary-500">
                        <div class="qrcode-container mx-auto" data-url="{{ route('driver.point', $driver->driver_id_card) }}"></div>
                    </div>
                    <p class="text-center text-xs text-gray-500 mt-2">Hanya untuk cek poin</p>
                </div>

                <!-- Footer -->
                <div class="px-4 py-3 bg-gray-100 text-center border-t border-gray-200">
                    <div class="flex items-center justify-center space-x-2 mb-1">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Poin: {{ number_format($driver->total_points) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- JsBarcode Library for 1D Barcode -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate all 1D Barcodes for scanning transactions
    document.querySelectorAll('.barcode-container').forEach(function(element) {
        const code = element.getAttribute('data-code');
        JsBarcode(element, code, {
            format: "CODE128",
            width: 1.5,
            height: 50,
            displayValue: true,
            fontSize: 12,
            margin: 5
        });
    });
    
    // Generate all QR codes for viewing points
    document.querySelectorAll('.qrcode-container').forEach(function(element) {
        new QRCode(element, {
            text: element.getAttribute('data-url'),
            width: 120,
            height: 120,
            colorDark: "#6366f1",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });
});
</script>

<style>
@media print {
    /* Hide non-printable elements */
    nav, header, .no-print, aside, .sidebar, button:not(.print-button) {
        display: none !important;
    }
    
    /* Reset page margins */
    @page {
        size: A4;
        margin: 1cm;
    }
    
    body {
        margin: 0;
        padding: 0;
    }
    
    /* Ensure proper spacing */
    .grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
    }
    
    /* Card styling for print */
    .bg-white {
        break-inside: avoid;
        page-break-inside: avoid;
    }
    
    /* Center QR code */
    .qrcode-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
</style>
@endsection
