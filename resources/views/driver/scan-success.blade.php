@extends('layouts.public')

@section('title', 'Scan Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-500 via-teal-600 to-blue-500 flex items-center justify-center p-4 relative">
    <!-- <div class="max-w-md w-full">
        Success Animation Card
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-slideInUp">
            Header dengan Checkmark Animation
            <div class="bg-gradient-to-r from-green-500 to-teal-500 p-8 text-center">
                <div class="mb-4 flex justify-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center animate-bounce-slow">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Scan Berhasil! ✓</h1>
                <p class="text-green-100 text-lg">Transaksi Telah Dicatat</p>
            </div>

            Transaction Info
            <div class="p-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 mb-6 border-2 border-blue-200">
                    <div class="text-center">
                        <p class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-2">ID Transaksi</p>
                        <p class="text-2xl font-mono font-bold text-gray-800">{{ $latestTransaction->transaction_id }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $latestTransaction->scan_time->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>

                Driver Info
                <div class="text-center mb-6">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-primary-500 to-purple-600 rounded-full flex items-center justify-center mb-3 shadow-lg">
                        <span class="text-white font-bold text-2xl">{{ strtoupper(substr($driver->name, 0, 2)) }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $driver->name }}</h2>
                    <p class="text-gray-500 font-mono text-sm">{{ $driver->driver_id_card }}</p>
                </div>

                Status Steps
                <div class="space-y-3 mb-6">
                    <div class="flex items-start space-x-3 bg-green-50 border-l-4 border-green-500 p-3 rounded">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-green-800">1. Scan Barcode</p>
                            <p class="text-xs text-green-600">Berhasil dicatat oleh sistem</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 animate-pulse">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-yellow-800">2. Menunggu Konfirmasi Admin</p>
                            <p class="text-xs text-yellow-600">Admin akan verifikasi dan input data pasien</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3 bg-gray-50 border-l-4 border-gray-300 p-3 rounded">
                        <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-600">3. Poin Ditambahkan</p>
                            <p class="text-xs text-gray-500">+1 poin setelah admin konfirmasi</p>
                        </div>
                    </div>
                </div>

             Current Points Display
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-5 border-2 border-yellow-200">
                    <div class="text-center">
                        <p class="text-gray-600 text-xs font-medium uppercase tracking-wide mb-2">Total Poin Saat Ini</p>
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-600 to-orange-600">
                                {{ number_format($driver->total_points) }}
                            </span>
                        </div>
                        <p class="text-gray-500 text-xs mt-2">Total transaksi terkonfirmasi: {{ $driver->total_confirmed_transactions }}</p>
                    </div>
                </div>
            </div>
        </div>

        Footer Note
        <div class="text-center mt-6 space-y-2">
            <p class="text-white text-base drop-shadow-lg font-semibold">
                Terima kasih atas dedikasi Anda! 🚑
            </p>
            <p class="text-green-100 text-sm drop-shadow">
                Silakan antarkan pasien ke ruangan yang dituju
            </p>
        </div>
    </div> -->

    <!-- Modal Form Data Pasien -->
    <div id="patientModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-20 hidden">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Input Data Pasien</h2>
            <p class="text-sm text-gray-500 mb-4">Silakan lengkapi data pasien yang sedang diantar.</p>

            <form action="{{ route('driver.scan.patient.validate', $latestTransaction->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pasien</label>
                    <input type="text" name="patient_name" value="{{ old('patient_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Masukkan nama pasien">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                    <textarea name="patient_condition" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Tuliskan keluhan utama pasien">{{ old('patient_condition') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tujuan <span class="text-red-500"></span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 border-2 border-gray-200 rounded-xl">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="destination" value="IGD" {{ old('destination') === 'IGD' ? 'checked' : '' }} required class="mr-3 text-primary-600 focus:ring-primary-500">
                                <div class="flex-1 flex items-center">
                                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                    </svg>
                                    <div class="font-semibold text-gray-900">IGD</div>
                                </div>
                            </label>
                        </div>
                        <div class="p-4 border-2 border-gray-200 rounded-xl">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="destination" value="Ponek" {{ old('destination') === 'Ponek' ? 'checked' : '' }} required class="mr-3 text-primary-600 focus:ring-primary-500">
                                <div class="flex-1 flex items-center">
                                    <svg class="w-6 h-6 mr-3" style="color: #ec4899;" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <div class="font-semibold text-gray-900">PONEK</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    @error('destination')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closePatientModal()" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700">Next</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup Sukses Setelah Simpan -->
    @if(session('success'))
    <div id="successPopup" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-br from-emerald-500 via-teal-500 to-green-600 px-5 py-3 text-center relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden rounded-t-2xl">
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-white/10 rounded-full blur-xl"></div>
                </div>
                
                <!-- Success Icon -->
                <div class="relative z-10 mx-auto mb-3 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <!-- Title -->
                <h3 class="relative z-10 text-2xl font-bold text-white mb-1">Data Tersimpan</h3>
                <p class="relative z-10 text-emerald-100 text-sm">Transaksi berhasil diproses</p>
            </div>
            
            <!-- Content Area -->
            <div class="px-8 py-6">
                <!-- Data Pasien Section -->
                <div class="mb-3">
                    <div class="flex items-center mb-3 ml-2">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 text-sm">Data Pasien</h4>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 ml-2">
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Nama</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="text-sm text-gray-800 font-medium ml-2">{{ session('success')['patient_name'] }}</span>
                            </div>
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Keluhan</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="text-sm text-gray-800 font-medium ml-2">{{ session('success')['patient_condition'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 font-medium w-16">Tujuan</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold {{ session('success')['destination'] == 'IGD' ? 'bg-red-100 text-red-800' : 'bg-purple-100 text-purple-800' }} ml-2">
                                    {{ session('success')['destination'] }}
                                </span>
                            </div>
                    </div>
                </div>
                
                <!-- Data Driver Section -->
                <div class="mb-4">
                    <div class="flex items-center mb-3 ml-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 text-sm">Driver Pengantar</h4>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 ml-2">
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Nama</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="text-sm text-gray-800 font-medium ml-2">{{ session('success')['driver_name'] }}</span>
                            </div>
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">ID Card</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="text-sm text-gray-800 font-mono bg-white px-2 py-1 rounded ml-2">{{ session('success')['driver_id_card'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 font-medium w-16">Waktu</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span class="text-sm text-gray-800 font-medium ml-2">{{ session('success')['scan_time'] }}</span>
                            </div>
                    </div>
                </div>
        
                
                <!-- Spacing before button -->
                <div class="mb-4"></div>
                
                <!-- Action Button -->
                <div class="flex justify-center px-4">
                    <button type="button" onclick="window.location.href='{{ route('scan.landing') }}'" class="w-full max-w-xs bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-2.5 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                        <span>Kembali ke Halaman Awal</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-15px);
    }
}

.animate-slideInUp {
    animation: slideInUp 0.6s ease-out;
}

.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}
</style>

<script>
    function openPatientModal() {
        var modal = document.getElementById('patientModal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closePatientModal() {
        var modal = document.getElementById('patientModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function closeSuccessPopup() {
        var popup = document.getElementById('successPopup');
        if (popup) {
            popup.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Otomatis buka form data pasien setelah halaman scan sukses muncul
        @if(!session('success'))
            openPatientModal();
        @endif
    });
</script>
@endsection
