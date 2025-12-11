<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - {{ config('app.name', 'SISTEM GARDA') }}</title>
    
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>
        
        <!-- Floating Shapes -->
        <div class="absolute top-20 left-20 w-16 h-16 bg-white/20 rounded-2xl rotate-12 animate-float hidden lg:block"></div>
        <div class="absolute bottom-20 right-20 w-20 h-20 bg-white/20 rounded-full animate-float hidden lg:block" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-white/15 rounded-lg rotate-45 animate-float hidden lg:block" style="animation-delay: 1s;"></div>
        
        <!-- Main Content -->
        <div class="w-full max-w-md relative z-10">
            @yield('content')
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
