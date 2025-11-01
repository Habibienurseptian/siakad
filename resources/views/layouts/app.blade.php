<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assalafi Al Fithrah Meteseh Semarang</title>
    
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"/>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans leading-normal tracking-normal">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        @include('layouts.sidebar')
    </aside>

    <!-- Overlay untuk mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden lg:hidden z-40"></div>

    <!-- Content -->
    <div class="lg:ml-64 flex flex-col min-h-screen transition-all duration-300">
        
        <!-- Header -->
        <header id="mainHeader" class="sticky top-0 z-30 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 py-4">

            <!-- Tombol Hamburger (muncul di mobile/ipad) -->
            <button id="menuToggle" class="lg:hidden p-2 rounded-md text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Judul -->
            <h1 class="text-xl md:text-2xl font-bold text-gray-900">
                @yield('title', 'Dashboard')
            </h1>

            <!-- Tanggal -->
            <div class="flex items-center space-x-2 p-2 bg-gray-100 rounded-full pr-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="currentDate" class="text-sm font-medium text-gray-800 tracking-wider"></span>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-1 px-4 md:px-6 lg:px-8 py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white text-gray-700 p-4 text-center border-t border-gray-200 text-sm">
            <div class="container mx-auto">
                &copy; {{ date('Y') }} Aplikasi Sekolah. Hak Cipta Dilindungi.
            </div>
        </footer>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sweetalert
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif
        });

        // Tanggal
        document.addEventListener('DOMContentLoaded', function () {
            const currentDateEl = document.getElementById('currentDate');
            function updateDate() {
                const now = new Date();
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const year = now.getFullYear();
                currentDateEl.textContent = `${day} / ${month} / ${year}`;
            }
            updateDate();
            setInterval(updateDate, 60000); 
        });

        // Toggle sidebar di mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuToggle = document.getElementById('menuToggle');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
        });
    </script>
</body>
</html>
