@extends('layouts.public')

@section('title', 'Scan / Cari ID Driver')

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

        <div class="relative w-full h-full p-6 sm:p-8 flex flex-col gap-6">
            <!-- Notifikasi Error dari Backend -->
            @if(session('error'))
                <div class="bg-red-500/90 backdrop-blur-sm text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-pulse">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                
                <!-- Script untuk auto-hide setelah 5 detik -->
                <script>
                    setTimeout(() => {
                        const errorDiv = document.querySelector('.bg-red-500\\/90');
                        if (errorDiv) {
                            errorDiv.style.transition = 'opacity 0.5s';
                            errorDiv.style.opacity = '0';
                            setTimeout(() => errorDiv.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif
            
            <!-- Top bar -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-white/90 border border-white/40 flex items-center justify-center shadow-inner overflow-hidden">
                        <img src="{{ asset('images/logo-garda.png') }}" alt="Logo GARDA" class="w-9 h-9 object-contain">
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.16em] text-amber-100/90 font-semibold">GARDA RSSG</p>
                    </div>
                </div>

                <!-- @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white text-sm font-medium rounded-lg border border-white/20 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Dashboard
                    </a>
                @endauth -->
            </div>

            <!-- Input dan Keypad Area -->
            <div class="flex-1 w-full max-w-sm mx-auto">
                <!-- Container untuk Input Field dan Tombol Enter (sebaris) -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-stretch gap-3" style="width: 300px;">
                        <!-- Input Field -->
                        <div class="flex-1">
                            <input 
                                type="text" 
                                id="driverIdCardInput" 
                                class="w-full px-4 py-4 rounded-2xl bg-white text-gray-800 text-lg font-medium tracking-wide text-center shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50 border border-gray-200 transition-all duration-200 h-14" 
                                placeholder="Masukkan ID Card" 
                                autocomplete="off" 
                                inputmode="tel"
                                pattern="[0-9]*"
                                required
                                oninvalid="this.setCustomValidity('Silakan masukkan ID Card')"
                                oninput="this.setCustomValidity('')"
                                formnovalidate
                            >
                        </div>
                        
                        <!-- Tombol Enter -->
                        <button 
                            type="button" 
                            onclick="submitManual()" 
                            class="flex items-center justify-center px-4 py-3 rounded-2xl bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 text-white font-semibold text-base shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 whitespace-nowrap h-14 min-w-[80px]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-1 h-1 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Enter</span>
                        </button>
                    </div>
                </div>
                
                <!-- Error Message -->
                <div id="error-message" class="hidden mb-2 text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="error-text"></span>
                    </div>
                </div>
                
                <!-- Keypad -->
                <div class="flex justify-center gap-2">
                    <div class="p-4 rounded-3xl backdrop-filter backdrop-blur-sm bg-white/30 shadow-2xl" style="width: 275px;">
                        <!-- Baris 1 -->
                        <div class="flex justify-center gap-3 mb-3">
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('1')" class="keypad-btn w-full">1</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('2')" class="keypad-btn w-full">2</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('3')" class="keypad-btn w-full">3</button>
                            </div>
                        </div>
                        
                        <!-- Baris 2 -->
                        <div class="flex justify-center gap-3 mb-3">
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('4')" class="keypad-btn w-full">4</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('5')" class="keypad-btn w-full">5</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('6')" class="keypad-btn w-full">6</button>
                            </div>
                        </div>
                        
                        <!-- Baris 3 -->
                        <div class="flex justify-center gap-3 mb-3">
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('7')" class="keypad-btn w-full">7</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('8')" class="keypad-btn w-full">8</button>
                            </div>
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('9')" class="keypad-btn w-full">9</button>
                            </div>
                        </div>
                        
                        <!-- Baris 4 -->
                        <div class="flex justify-center gap-3">
                            <div class="w-16"></div> <!-- Kolom kosong -->
                            <div class="w-16">
                                <button type="button" onclick="pressKeypadDigit('0')" class="keypad-btn w-full">0</button>
                            </div>
                            <div class="w-16">
                                <button type="button" 
                                    onclick="backspaceIdInput()" 
                                    class="w-16 h-16 bg-red-600 hover:bg-red-700 text-white rounded-xl flex items-center justify-center border-2 border-red-700 shadow-md hover:shadow-lg transition-all duration-200">
                                    <img src="{{ asset('images/icon-delete.png') }}" 
                                        alt="Hapus" 
                                        class="w-8 h-8">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-xs text-center text-white/80 mt-6 tracking-wider">
                *Melayani Dengan Hati.*
            </p>
        </div>
    </div>
</div>

<!-- Popup Not Found -->
<!-- <div id="notFoundPopup" class="popup-overlay" style="display: none;">
    <div class="popup-content">
        <div class="popup-icon">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <h2 class="popup-title">ID Card Tidak Ditemukan</h2>
        <p class="popup-message" id="popupMessage">
            ID Card <span id="driverIdDisplay" class="font-bold"></span> tidak terdaftar dalam sistem.
            <br>Silakan periksa kembali atau hubungi admin.
        </p>
        <button onclick="closeNotFoundPopup()" class="popup-button">
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                TUTUP & COBA LAGI
            </span>
        </button>
    </div>
</div> -->

<style>
    /* Style untuk tombol keypad */
    .keypad-btn {
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 500;
        background-color: #ffffffc0;
        color: #1f2937;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        cursor: pointer;
        margin: 0;
    }

    .keypad-btn:hover {
        background-color: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .keypad-btn:active {
        transform: translateY(0);
        background-color: #f3f4f6;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Style untuk popup not found */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease-out;
    }

    .popup-content {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 24px;
        padding: 2rem;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        border: 2px solid #fbbf24;
        animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .popup-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 4px solid white;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
    }

    .popup-title {
        color: #b91c1c;
        font-size: 1.75rem;
        font-weight: 800;
        text-align: center;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .popup-message {
        color: #92400e;
        text-align: center;
        font-size: 1.1rem;
        line-height: 1.5;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .popup-button {
        display: block;
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
    }

    .popup-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(220, 38, 38, 0.5);
    }

    .popup-button:active {
        transform: translateY(-1px);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
</style>

<script>
    // =================== VARIABLES ===================
    let scannerBuffer = '';
    let scannerTimer = null;
    let startTime = null;
    let isManualInput = false;
    const SCANNER_TIMEOUT = 150; // ms
    
    // =================== FUNCTIONS ===================
    
    // 1. Fungsi untuk submit MANUAL (tombol Enter)
    function submitManual() {
        const input = document.getElementById('driverIdCardInput');
        
        if (!input || !input.value) {
            showError('Silakan masukkan ID Card');
            return;
        }
        
        const cleanId = cleanInput(input.value);
        if (!cleanId) {
            showError('ID Card tidak valid');
            return;
        }
        
        console.log('Manual submission - ID:', cleanId);
        validateAndSubmit(cleanId);
    }
    
    // 2. Fungsi untuk membersihkan input
    function cleanInput(value) {
        return value.replace(/[^0-9]/g, '').trim();
    }
    
    // 3. Fungsi validasi dan submit ke API
    async function validateAndSubmit(driverId) {
        const cleanId = driverId.replace(/[^0-9]/g, '');
        
        // Tampilkan loading
        const submitBtn = document.querySelector('button[onclick="submitManual()"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memeriksa...</span>';
        }
        
        try {
            const response = await fetch(`/api/check-driver/${cleanId}`);
            const data = await response.json();
            
            if (data.exists) {
                window.location.href = `/driver/scan/${cleanId}`;
            } else {
                // Langsung redirect ke halaman driver-not-found
                window.location.href = `/driver-not-found?driver_id=${cleanId}`;
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg><span>Enter</span>';
            }
        }
    }
    
    // 4. Fungsi untuk menampilkan popup not found
    function showNotFoundPopup(driverId) {
        // Update ID driver di popup
        document.getElementById('driverIdDisplay').textContent = driverId;
        
        // Tampilkan popup dengan animasi
        const popup = document.getElementById('notFoundPopup');
        popup.style.display = 'flex';
        
        // Animasi shake untuk input field
        const input = document.getElementById('driverIdCardInput');
        if (input) {
            input.style.animation = 'shake 0.5s ease';
            input.focus();
            input.select();
            
            // Reset animasi setelah selesai
            setTimeout(() => {
                input.style.animation = '';
            }, 500);
        }
        
        // Tambahkan efek suara jika diinginkan (opsional)
        if (typeof Audio !== 'undefined') {
            try {
                const audio = new Audio('data:audio/wav;base64,UklGRigAAABXQVZFZm10IBIAAAABAAEAQB8AAEAfAAABAAgAZGF0YQ');
                audio.play().catch(() => {});
            } catch (e) {}
        }
    }
    
    // 5. Fungsi untuk menutup popup
    function closeNotFoundPopup() {
        const popup = document.getElementById('notFoundPopup');
        popup.style.display = 'none';
        
        // Fokus kembali ke input field
        const input = document.getElementById('driverIdCardInput');
        if (input) {
            input.focus();
            input.select();
        }
    }
    
    // 6. Fungsi untuk keypad
    function pressKeypadDigit(digit) {
        const input = document.getElementById('driverIdCardInput');
        if (!input) return;
        
        // Haptic feedback
        if (navigator.vibrate) navigator.vibrate(50);
        
        // Reset scanner detection karena ini manual input
        scannerBuffer = '';
        clearTimeout(scannerTimer);
        
        // Tambahkan digit
        input.value = (input.value || '') + digit;
        input.focus();
    }
    
    // 7. Fungsi backspace
    function backspaceIdInput() {
        const input = document.getElementById('driverIdCardInput');
        if (input && input.value.length > 0) {
            if (navigator.vibrate) navigator.vibrate(30);
            input.value = input.value.slice(0, -1);
            input.focus();
            
            // Reset scanner detection
            scannerBuffer = '';
            clearTimeout(scannerTimer);
        }
    }
    
    // 8. Fungsi show error (untuk pesan error kecil)
    function showError(message) {
        const errorElement = document.getElementById('errorMessage');
        if (errorElement) {
            errorElement.textContent = message;
            setTimeout(() => {
                errorElement.textContent = '';
            }, 3000);
        }
    }
    
    // =================== EVENT LISTENERS ===================
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('driverIdCardInput');
        
        if (!input) return;
        
        // Fokus ke input saat halaman dimuat
        input.focus();
        
        // 1. EVENT UNTUK DETEKSI SCANNER VS MANUAL INPUT
        input.addEventListener('input', function(e) {
            const currentValue = this.value;
            
            // Reset timer sebelumnya
            clearTimeout(scannerTimer);
            
            // Set start time untuk input pertama
            if (!startTime || scannerBuffer.length === 0) {
                startTime = Date.now();
            }
            
            // Simpan ke buffer
            scannerBuffer = currentValue;
            
            // Timer untuk deteksi scanner (scanner input cepat)
            scannerTimer = setTimeout(() => {
                const endTime = Date.now();
                const inputDuration = endTime - startTime;
                const avgTimePerChar = scannerBuffer.length > 0 ? inputDuration / scannerBuffer.length : 0;
                
                console.log('Input analysis:', {
                    length: scannerBuffer.length,
                    duration: inputDuration,
                    avgTimePerChar: avgTimePerChar,
                    isManualInput: isManualInput
                });
                
                // JIKA INI MANUAL INPUT (dari keyboard), HANYA ≥12 digit yang auto-submit
                if (isManualInput) {
                    if (scannerBuffer.length >= 12 && /^\d+$/.test(scannerBuffer)) {
                        console.log('Manual keyboard input detected - auto-submitting:', scannerBuffer);
                        checkDriverForScanner(scannerBuffer);
                    }
                    // Manual input <12 digit: TIDAK ADA AUTO-SUBMIT
                    else {
                        console.log('Manual keyboard input <12 digit - no auto-submit:', scannerBuffer.length);
                    }
                }
                // JIKA INI SCANNER (input sangat cepat), auto-submit untuk ≥6 digit
                else if (scannerBuffer.length >= 6 && /^\d+$/.test(scannerBuffer) && avgTimePerChar < 30) {
                    console.log('Scanner detected - auto-submitting:', scannerBuffer);
                    checkDriverForScanner(scannerBuffer);
                }
                
                // Reset buffer dan timer
                scannerBuffer = '';
                startTime = null;
                isManualInput = false;
            }, SCANNER_TIMEOUT + 50);
        });
        
        // 2. DETEKSI MANUAL INPUT (keyboard events)
        input.addEventListener('keydown', function(e) {
            // Jika ini input dari keyboard (bukan paste), tandai sebagai manual input
            if (e.key >= '0' && e.key <= '9') {
                isManualInput = true;
                console.log('Manual keyboard input detected');
            }
        });
        
        // 2. BLOCK SEMUA ENTER KEY DI INPUT
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                console.log('Tombol Enter diblokir - gunakan tombol Enter hijau');
                
                // Feedback visual yang lebih soft untuk manual input
                this.style.boxShadow = '0 0 0 2px #10b981';
                setTimeout(() => {
                    this.style.boxShadow = '';
                }, 200);
                return false;
            }
        });
        
        // Juga block di keypress untuk browser tertentu
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });
        
        // Tutup popup dengan ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNotFoundPopup();
            }
        });
    });
    
    // Fungsi untuk cek driver dari scanner
    async function checkDriverForScanner(driverId) {
        const cleanId = driverId.replace(/[^0-9]/g, '');
        
        try {
            const response = await fetch(`/api/check-driver/${cleanId}`);
            const data = await response.json();
            
            if (data.exists) {
                window.location.href = `/driver/scan/${cleanId}`;
            } else {
                // Langsung redirect ke halaman driver-not-found untuk scanner juga
                window.location.href = `/driver-not-found?driver_id=${cleanId}`;
            }
        } catch (error) {
            console.error('Error checking scanner:', error);
            // Jika error, tetap redirect tapi ke halaman not found
            window.location.href = `/driver/scan/${cleanId}`;
        }
    }
</script>
@endsection