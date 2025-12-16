@extends('layouts.public')

@section('title', 'Validasi Data Pasien')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-500 via-teal-600 to-blue-500 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Floating Shapes -->
    <div class="absolute top-20 left-20 w-16 h-16 bg-white/20 rounded-2xl rotate-12 animate-float hidden lg:block"></div>
    <div class="absolute bottom-20 right-20 w-20 h-20 bg-white/20 rounded-full animate-float hidden lg:block" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-white/15 rounded-lg rotate-45 animate-float hidden lg:block" style="animation-delay: 1s;"></div>
    
    <div class="relative w-full max-w-4xl rounded-[32px] overflow-hidden shadow-[0_20px_60px_rgba(15,23,42,0.85)] border border-green/10 bg-gradient-to-br from-green/10 via-green/5 to-sky-500/20 backdrop-blur-2xl">
        <!-- Glow decorations -->
        <div class="pointer-events-none absolute -top-24 -left-16 h-56 w-56 rounded-full bg-amber-300/55 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-16 h-56 w-56 rounded-full bg-emerald-400/55 blur-3xl"></div>

        <div class="relative w-full h-full p-6 sm:p-8 flex flex-col gap-4">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-white/90 border border-white/40 flex items-center justify-center shadow-inner overflow-hidden">
                        <img src="{{ asset('images/logo-garda.png') }}" alt="Logo GARDA" class="w-9 h-9 object-contain">
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.16em] text-amber-100/90 font-semibold">GARDA RSSG</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Pastikan Data Sudah Benar
                    </span>
                </div>
            </div>

            <!-- Alert Validasi -->
            <!-- <div class="bg-amber-50/90 backdrop-blur-sm border border-amber-200/50 rounded-xl p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div> -->
                    <!-- <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800">Pastikan Data Sudah Benar</h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <p>Periksa kembali semua data pasien di bawah ini. Pastikan semua informasi sudah benar sebelum menyimpan.</p>
                        </div>
                    </div> -->
                <!-- </div>
            </div> -->

            <!-- Form Validation -->
            <form action="{{ route('driver.scan.patient', $transaction->id) }}" method="POST" id="validationForm">
                @csrf
                <input type="hidden" name="validated" value="true">
                
                <!-- Hidden fields untuk menyimpan data -->
                <input type="hidden" name="patient_name" value="{{ $patientData['patient_name'] }}">
                <input type="hidden" name="patient_condition" value="{{ $patientData['patient_condition'] }}">
                <input type="hidden" name="destination" value="{{ $patientData['destination'] }}">

                <!-- Data Pasien -->
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Data Pasien</h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Informasi Pasien -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Informasi Pasien</h4>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $patientData['patient_name'] ?: 'Tidak ada nama' }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan/Diagnosis</label>
                                    <p class="mt-1 text-gray-900 whitespace-pre-wrap">{{ $patientData['patient_condition'] ?: 'Tidak ada keluhan' }}</p>
                                </div>
                            </div>

                            <!-- Informasi Kunjungan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Informasi Kunjungan</h4>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">
                                        @switch($patientData['destination'])
                                            @case('IGD')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">IGD</span>
                                                @break
                                            @case('Ponek')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">Ponek</span>
                                                @break
                                            @default
                                                <span class="text-gray-500">{{ $patientData['destination'] }}</span>
                                        @endswitch
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Kedatangan</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">
                                        {{ now()->format('d/m/Y H:i') }} WIB
                                    </p>
                                </div>

                                <!-- Informasi Driver -->
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                    <label class="text-xs font-medium text-blue-600 uppercase tracking-wider">Informasi Driver</label>
                                    <div class="mt-2 flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm mr-3">
                                            {{ strtoupper(substr($driver->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $driver->name }}</div>
                                            <div class="text-xs text-gray-500">ID Transaksi: {{ $transaction->transaction_id }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spacing sebelum tombol aksi -->
                <div class="mt-4"></div>
                
                <!-- Tombol Aksi -->
                <div class="flex justify-between space-x-3 gap-6">
                    <button type="button" 
                            onclick="goBackToInput()"
                            class="px-6 py-2.5 bg-gray-200/90 backdrop-blur-sm text-gray-700 font-medium rounded-lg hover:bg-gray-300/90 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Input
                    </button>
                    
                    <div class="flex space-x-3 gap-4">
                        <button type="button" 
                                onclick="window.location.href='{{ route('scan.landing') }}'"
                                class="px-6 py-2.5 bg-gray-200/90 backdrop-blur-sm text-gray-700 font-medium rounded-lg hover:bg-gray-300/90 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('validationForm');
    
    // Konfirmasi sebelum submit
    // form.addEventListener('submit', function(e) {
    //     const confirmed = confirm('Apakah Anda yakin ingin menyimpan data pasien ini?');
    //     if (!confirmed) {
    //         e.preventDefault();
    //     }
    // });
});

function goBackToInput() {
    // Data sudah tersimpan di session dari controller, langsung navigasi
    window.location.href = '{{ route('driver.scan', $driver->driver_id_card) }}';
}
</script>
@endsection
