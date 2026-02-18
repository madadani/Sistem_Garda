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
            <form action="{{ route('driver.scan.patient', $driver->driver_id_card) }}" method="POST" id="validationForm">
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
                                    <div class="mt-2 flex items-start">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm mr-3 flex-shrink-0">
                                            {{ strtoupper(substr($driver->name, 0, 2)) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $driver->name }}</div>
                                            <div class="text-xs text-gray-500">ID Card: {{ $driver->driver_id_card }}</div>
                                            <div class="text-xs text-gray-500">No. HP: {{ $driver->phone_number ?? 'Tidak Ada' }}</div>
                                            <div class="text-xs text-gray-500">Instansi: {{ $driver->instansi ?? 'Tidak Ada' }}</div>
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

    <!-- Popup Sukses Setelah Simpan -->
    <div id="successPopup" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 hidden">
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
                        <h4 class="font-semibold text-gray-800 text-sm">Informasi Pasien</h4>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 ml-2">
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Nama</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resPatientName" class="text-sm text-gray-800 font-medium ml-2"></span>
                            </div>
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Keluhan</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resPatientCondition" class="text-sm text-gray-800 font-medium ml-2"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 font-medium w-16">Tujuan</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resDestination" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold ml-2"></span>
                            </div>
                    </div>
                </div>
                
                <!-- Informasi Driver Section -->
                <div class="mb-4">
                    <div class="flex items-center mb-3 ml-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 text-sm">Informasi Driver</h4>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 ml-2">
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">Nama</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resDriverName" class="text-sm text-gray-800 font-medium ml-2"></span>
                            </div>
                            <div class="flex items-center pb-2">
                                <span class="text-xs text-gray-500 font-medium w-16">ID Card</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resDriverIdCard" class="text-sm text-gray-800 font-mono bg-white px-2 py-1 rounded ml-2"></span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs text-gray-500 font-medium w-16">Waktu</span>
                                <span class="text-sm text-gray-800 font-medium">:</span>
                                <span id="resScanTime" class="text-sm text-gray-800 font-medium ml-2"></span>
                            </div>
                    </div>
                </div>
        
                <!-- Tombol Aksi -->
                <div class="flex justify-center px-4">
                    <button type="button" onclick="window.location.href='{{ route('scan.landing') }}'" class="w-full max-w-xs bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-2.5 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <span>Kembali ke Halaman Awal</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('validationForm');
    const successPopup = document.getElementById('successPopup');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            // Loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-4 w-4 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Update content modal
                    document.getElementById('resPatientName').textContent = result.data.patient_name || '-';
                    document.getElementById('resPatientCondition').textContent = result.data.patient_condition || '-';
                    
                    const destEl = document.getElementById('resDestination');
                    destEl.textContent = result.data.destination;
                    if (result.data.destination === 'IGD') {
                        destEl.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 ml-2';
                    } else {
                        destEl.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 ml-2';
                    }
                    
                    document.getElementById('resDriverName').textContent = result.data.driver_name;
                    document.getElementById('resDriverIdCard').textContent = result.data.driver_id_card;
                    document.getElementById('resScanTime').textContent = result.data.scan_time;
                    
                    // Tampilkan modal
                    successPopup.classList.remove('hidden');
                } else {
                    alert(result.message || 'Gagal menyimpan data');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalContent;
            });
        });
    }
});

function goBackToInput() {
    window.location.href = '{{ route('driver.scan', $driver->driver_id_card) }}';
}
</script>
@endsection
