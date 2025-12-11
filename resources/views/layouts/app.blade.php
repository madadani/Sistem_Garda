<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'SISTEM GARDA') }}</title>
    
    <!-- Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Pusher JS -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <!-- Laravel Echo (IIFE build exposes global Echo constructor) -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <script>
        // Inisialisasi Laravel Echo dengan Pusher
        if (typeof Pusher !== 'undefined') {
            window.Pusher = Pusher;
            if (!window.Echo) {
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ config('broadcasting.connections.pusher.key') }}',
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    forceTLS: true,
                });
            }
        }
    </script>
    
    @stack('styles')
    
    <!-- Global Functions -->
    <script>
        // Fungsi untuk membuka modal tukar poin
        function openTukarPoinModal(driverId, totalPoints, driverName) {
            console.log('Fungsi openTukarPoinModal dipanggil dengan:', {driverId, totalPoints, driverName});
            
            const modal = document.getElementById('tukarPoinModal');
            if (!modal) {
                console.error('Modal tidak ditemukan');
                return;
            }
            
            modal.style.display = 'block';
            document.getElementById('tukarDriverId').value = driverId;
            document.getElementById('totalPoinTersedia').textContent = totalPoints.toLocaleString('id-ID');
            document.getElementById('points').setAttribute('max', totalPoints);
            document.getElementById('formTukarPoin').dataset.driverName = driverName;
            
            // Reset form
            document.getElementById('points').value = '';
            document.getElementById('nilaiTukar').textContent = 'Rp 0';
            
            console.log('Modal seharusnya terbuka sekarang');
        }
        
        // Fungsi untuk menutup modal
        function closeTukarPoinModal() {
            const modal = document.getElementById('tukarPoinModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</head>
<body class="antialiased bg-gray-50">
    <!-- Alerts -->
    @include('components.alerts')
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('components.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('components.header')
            
            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Overlay untuk mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>
    
    <script>
        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar) {
                // Check if mobile
                if (window.innerWidth < 768) {
                    // Mobile: show/hide sidebar
                    sidebar.classList.toggle('sidebar-open');
                    if (overlay) overlay.classList.toggle('hidden');
                } else {
                    // Desktop: expand/collapse sidebar
                    sidebar.classList.toggle('sidebar-collapsed');
                    sidebar.classList.toggle('sidebar-expanded');
                }
            }
        }
        
        // Close sidebar saat klik overlay
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                toggleSidebar();
            });
        }
        
        // Dropdown user menu
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }
        
        // Close dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            
            if (userMenuButton && !userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
    
    <script>
        // Confirmation Delete
        function confirmDelete(event, form) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>