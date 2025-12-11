@extends('layouts.public')

@section('title', 'ID Driver Tidak Terdaftar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-500 via-orange-400 to-amber-300 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-red-400/55 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-orange-500/55 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-amber-400/40 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Main Container -->
    <div class="relative w-full max-w-lg mx-auto">
        <div class="relative w-full max-w-4xl rounded-[32px] overflow-hidden shadow-[0_20px_60px_rgba(220,38,38,0.85)] border border-red-200/50 bg-gradient-to-br from-red-50/90 via-orange-50/80 to-amber-50/70 backdrop-blur-2xl">
            <!-- Warning Icon with Pulse Animation -->
            <div class="absolute -top-10 left-1/2 -translate-x-1/2">
                <div class="relative">
                    <div class="absolute inset-0 bg-red-500 rounded-full animate-ping opacity-75"></div>
                    <div class="relative w-20 h-20 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-orange-500 px-6 py-8 pt-16 text-center">
                <h1 class="text-2xl font-bold text-white mb-2">⚠ ID Driver Tidak Terdaftar</h1>
                <p class="text-white/90 text-sm">Sistem tidak dapat menemukan data driver</p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Error Message Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-red-100 shadow-inner">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800">ID Tidak Ditemukan</h3>
                            @if(isset($driver_id))
                            <p class="text-sm text-gray-600">ID: <span class="font-mono font-bold text-red-600">{{ $driver_id }}</span></p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                ID Card yang Anda masukkan <span class="font-bold text-red-600">tidak terdaftar</span> dalam database sistem.
                            </p>
                        </div>
                        
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                Pastikan Anda memasukkan ID yang benar atau hubungi admin untuk verifikasi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('scan.landing') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Home
                    </a>
                    
                    <button onclick="window.history.back()" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Coba Lagi
                    </button>
                </div>

                <!-- Auto Redirect Timer -->
                <div class="text-center pt-4">
                    <div class="inline-flex items-center gap-3 px-5 py-3 bg-red-50/80 backdrop-blur-sm rounded-2xl border border-red-200 shadow">
                        <div class="relative">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-medium text-red-700">Auto redirect dalam</p>
                            <div class="flex items-center gap-1">
                                <div id="countdown" class="text-xl font-bold text-red-600">10</div>
                                <span class="text-sm text-red-600">detik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced countdown with visual feedback
    let countdown = 10;
    const countdownElement = document.getElementById('countdown');
    
    const updateCountdown = () => {
        countdown--;
        if (countdownElement) {
            countdownElement.textContent = countdown;
            
            // Visual feedback
            if (countdown <= 3) {
                countdownElement.classList.add('animate-pulse', 'text-red-700');
                countdownElement.classList.remove('text-red-600');
            } else if (countdown <= 5) {
                countdownElement.classList.add('animate-pulse');
            }
            
            // Add vibration on last 3 seconds (if supported)
            if (countdown <= 3 && navigator.vibrate) {
                navigator.vibrate(200);
            }
        }
        
        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = '{{ route("scan.landing") }}';
        }
    };
    
    const timer = setInterval(updateCountdown, 1000);
    
    // Cancel on any interaction
    document.addEventListener('click', () => {
        clearInterval(timer);
        const timerContainer = document.querySelector('.text-left p');
        if (timerContainer) {
            timerContainer.textContent = 'Redirect dibatalkan - Anda dapat menutup halaman ini';
            timerContainer.classList.add('text-green-600');
        }
        if (countdownElement) {
            countdownElement.parentElement.innerHTML = '<span class="text-sm text-green-600 font-medium">✓ Dibatalkan</span>';
        }
    });
    
    // Also cancel on keypress
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === ' ') {
            clearInterval(timer);
        }
    });
</script>

<style>
    /* Custom pulse animation for warning icon */
    @keyframes warning-pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    
    @keyframes ping {
        75%, 100% {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
@endsection