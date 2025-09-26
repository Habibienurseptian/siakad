<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for 'Inter' -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            /* Latar belakang gradasi yang sama untuk konsistensi */
            background: linear-gradient(to bottom right, #f3f4f6, #e5e7eb);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 md:p-8">
    
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-2xl w-full max-w-sm transition-all duration-300 transform hover:shadow-3xl">
        
        <!-- Header Section -->
        <div class="text-center mb-6">
            <div class="mx-auto h-14 w-14 rounded-full flex items-center justify-center bg-blue-50 text-blue-600 shadow-md">
                <!-- Ikon pendaftaran yang relevan (user dengan tanda plus) -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.5h-2.25m-4.5 0H9m-2.25 0h-2.25M15.75 6a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zM12 18H5.25A2.25 2.25 0 013 15.75v-1.5a2.25 2.25 0 012.25-2.25H12a2.25 2.25 0 012.25 2.25v1.5A2.25 2.25 0 0112 18z" />
                </svg>
            </div>
            <h2 class="text-2xl md:text-2xl font-extrabold text-gray-900 mt-3">Daftar Akun Baru</h2>
            <p class="mt-1 text-sm md:text-base text-gray-600">Isi formulir di bawah untuk membuat akun Anda.</p>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Nama Lengkap Field -->
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" placeholder="Nama lengkap Anda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                </div>
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" placeholder="nama@contoh.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                </div>
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" id="password" placeholder="Masukkan kata sandi Anda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                </div>
                <!-- Konfirmasi Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi Anda" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 text-gray-900" required>
                </div>
            </div>
            
            <!-- Submit Button dengan gradasi dan shadow yang lebih baik -->
            <button type="submit" class="w-full mt-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Daftar
            </button>
        </form>
        
        <!-- Login Link -->
        <p class="mt-4 text-center text-gray-600 text-xs">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk sekarang</a>
        </p>
    </div>
</body>
</html>
