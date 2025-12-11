@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="glass-effect rounded-3xl shadow-2xl p-8 md:p-10 transform transition-all duration-300 hover:shadow-3xl">
    <!-- Logo & Header -->
    <div class="text-center mb-8">
            <!-- Logo/Icon Area - NOW USING BASE64 IMAGE -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl shadow-lg mb-4 transform transition-transform duration-300 hover:scale-105">
                <img 
                    src="data:image/jpeg;base64,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"
                    alt="Sistem Garda Logo"
                    class="w-15 h-15 rounded-full"
                >
            </div>
            <!-- Title and Subtitle -->
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 tracking-tight">SISTEM GARDA</h1>
            <p class="text-gray-500 text-base md:text-lg">Silakan masuk ke akun Anda</p>
        </div>

    <!-- Error Alert -->
    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan</h3>
                <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <!-- Username Field -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-medium text-gray-700">
                Username
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="input-focus w-full pl-12 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-500 focus:bg-white transition-all duration-200"
                    placeholder="Masukkan username"
                    required
                    autofocus
                >
            </div>
        </div>

        <!-- Password Field -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-700">
                Password
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="input-focus w-full pl-12 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary-500 focus:bg-white transition-all duration-200"
                    placeholder="Masukkan password"
                    required
                >
                <button 
                    type="button" 
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                >
                    <svg id="eye-open" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="eye-closed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label class="flex items-center cursor-pointer group">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="w-4 h-4 text-primary-600 bg-gray-50 border-gray-300 rounded focus:ring-primary-500 focus:ring-2 transition-all"
                >
                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-primary-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
        >
            <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Masuk
            </span>
        </button>
    </form>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            &copy; {{ date('Y') }} SISTEM GARDA. All rights reserved.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        }
    }
</script>
@endpush
