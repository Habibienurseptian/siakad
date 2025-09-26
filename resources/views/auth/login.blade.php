<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: url('/images/sekolah.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 md:p-8">
    
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-2xl w-full max-w-sm transition-all duration-300 transform hover:shadow-3xl">
        
        <!-- Header Section -->
        <div class="text-center mb-6">
            <div class="mx-auto h-14 w-14 rounded-full flex items-center justify-center bg-green-50 text-green-600 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.14a1.5 1.5 0 012.12 0l4.766 4.765a1.5 1.5 0 002.122 0l4.765-4.765a1.5 1.5 0 012.122 0l1.765 1.765a.75.75 0 010 1.06l-6.765 6.765a1.5 1.5 0 01-2.122 0l-6.765-6.765a.75.75 0 010-1.06l1.765-1.765z" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 mt-3">Selamat Datang</h2>
            <p class="mt-1 text-sm text-gray-600">Masuk ke akun Anda untuk melanjutkan.</p>
        </div>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" placeholder="nama@contoh.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 text-gray-900" required>
                </div>
                <!-- Password Field -->
                <div class="flex flex-col">
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <div class="relative flex items-center">
                        <input type="password" name="password" id="password" placeholder="Masukkan kata sandi Anda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 text-gray-900 pr-12 transition-all duration-200" required>
                        <button type="button" id="togglePassword" tabindex="-1" class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center justify-center text-green-500 hover:text-green-700 transition-all duration-200 focus:outline-none">
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M6.634 6.634A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.432 5.568M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button dengan gradasi dan shadow yang lebih baik -->
            <button type="submit" class="w-full mt-6 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Masuk
            </button>
        </form>
        
        <!-- Registration Link -->
        <p class="mt-4 text-center text-gray-600 text-xs">
            Belum punya akun? <a href="{{route ('register') }}" class="text-blue-600 font-semibold hover:underline">Daftar sekarang</a>
        </p>
    </div>


    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts') {{-- Optional tambahan JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden', !isPassword);
            eyeClosed.classList.toggle('hidden', isPassword);
        });
    }

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

        {{-- Tambahan untuk error login/email/password salah --}}
        @if($errors->any())
            Swal.fire({
                toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: 'error',
                    title: '{{ $errors->first() }}'
                });
            @endif
        });
    </script>

</body>
</html>
