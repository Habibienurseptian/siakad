@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card Container -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 text-center">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white">Reset Password</h2>
                <p class="text-green-100 text-sm mt-1">Perbarui password akun Anda</p>
            </div>

            <!-- Form Section -->
            <div class="px-8 py-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 animate-shake">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-red-800 mb-1">Terjadi kesalahan:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('murid.password.update') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Current Password -->
                    <div class="group">
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Lama
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password" name="current_password" id="current_password" required
                                   class="w-full pl-12 pr-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 outline-none"
                                   placeholder="Masukkan password lama">
                            <button type="button" onclick="togglePassword('current_password')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-current_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-slash-current_password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="group">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <input type="password" name="new_password" id="new_password" required
                                   class="w-full pl-12 pr-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 outline-none"
                                   placeholder="Masukkan password baru">
                            <button type="button" onclick="togglePassword('new_password')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-new_password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-slash-new_password" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Minimal 8 karakter, kombinasi huruf dan angka</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="group">
                        <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                   class="w-full pl-12 pr-12 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 outline-none"
                                   placeholder="Konfirmasi password baru">
                            <button type="button" onclick="togglePassword('new_password_confirmation')" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="eye-new_password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-slash-new_password_confirmation" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3.5 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center group">
                        <span>Simpan Password Baru</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>

                    <!-- Back Link -->
                    <div class="pt-4 text-center">
                        <a href="{{ route('murid.profile') }}" 
                           class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-green-600 transition-colors group">
                            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Profil
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Info -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-600 flex items-center justify-center">
                <svg class="w-4 h-4 mr-1.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Password Anda akan dienkripsi dengan aman
            </p>
        </div>
    </div>
</div>

<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}
</style>

<script>
function togglePassword(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById('eye-' + fieldId);
    const eyeSlashIcon = document.getElementById('eye-slash-' + fieldId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
}
</script>
@endsection