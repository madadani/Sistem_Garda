<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'GARDA RSSG')</title>
    
    <!-- Tailwind CSS dengan Fallback -->
    @if(file_exists(public_path('css/app.css')))
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
        <!-- CDN Fallback jika file tidak ditemukan -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'green': {
                                50: '#f0fdf4',
                                500: '#06f35dff',
                                600: '#16a34a',
                            },
                            'teal': {
                                500: '#14b8a6',
                                600: '#0d9488',
                            },
                            'blue': {
                                500: '#3b82f6',
                                600: '#2563eb',
                            },
                            'red': {
                                50: '#fef2f2',
                                500: '#ef4444',
                                600: '#dc2626',
                            },
                            'orange': {
                                400: '#fb923c',
                                500: '#f97316',
                            },
                            'amber': {
                                300: '#fcd34d',
                                400: '#fbbf24',
                            }
                        }
                    }
                }
            }
        </script>
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles untuk tambahan */
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="antialiased">
    @yield('content')
        
        <!-- Floating Shapes -->
        <div class="absolute top-20 left-20 w-16 h-16 bg-white/20 rounded-2xl rotate-12 animate-float hidden lg:block"></div>
        <div class="absolute bottom-20 right-20 w-20 h-20 bg-white/20 rounded-full animate-float hidden lg:block" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-white/15 rounded-lg rotate-45 animate-float hidden lg:block" style="animation-delay: 1s;"></div>
        
    
    </div>
</body>
</html>