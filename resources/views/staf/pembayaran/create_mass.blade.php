@extends('layouts.app')

@section('title', 'Tagihan Massal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('staf.pembayaran.index') }}" 
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md hover:shadow-lg text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-105 mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Input Tagihan Massal</h1>
            </div>
        </div>

        <!-- School Info Card -->
        <div class="mb-8 bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">{{ $sekolah->nama }}</h2>
                        <p class="text-green-100 text-sm">Tagihan akan diterapkan untuk semua siswa aktif</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-green-50">
                <div class="flex items-center text-sm text-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Pastikan data tagihan sudah sesuai sebelum menyimpan</span>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="group relative">
            <!-- Glow Effect -->
            <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
            
            <!-- Form Card -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Form Tagihan Massal</h2>
                            <p class="text-emerald-100 text-sm">Masukkan detail tagihan untuk semua siswa</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form method="POST" action="{{ route('staf.pembayaran.input.mass.store', $sekolah->id) }}">
                        @csrf

                        <!-- Payment Types Grid -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                Jenis Pembayaran
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- SPP -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        </div>
                                        Pembayaran SPP
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="pembayaran_spp" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang Saku -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-indigo-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                                        </div>
                                        Uang Saku
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_saku" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang Kegiatan -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                        </div>
                                        Uang Kegiatan
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_kegiatan" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang SPI -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-pink-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                        </div>
                                        Uang SPI
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_spi" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang Haul/Maulid -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-yellow-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                        </div>
                                        Uang Haul/Maulid
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_haul_maulid" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang Khidmah/Infaq -->
                                <div class="group">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        </div>
                                        Uang Khidmah/Infaq
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_khidmah_infaq" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>

                                <!-- Uang Zakat -->
                                <div class="group md:col-span-2 lg:col-span-1">
                                    <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                        <div class="w-5 h-5 bg-teal-100 rounded-lg flex items-center justify-center mr-2">
                                            <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                                        </div>
                                        Uang Zakat
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               name="uang_zakat" 
                                               class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300"
                                               placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Period -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Periode Tagihan
                            </h3>
                            
                            <div class="max-w-md">
                                <label class="flex items-center text-sm font-medium text-gray-700 mb-3">
                                    <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Periode
                                </label>
                                <input type="text" 
                                       name="periode" 
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-300" 
                                       placeholder="Contoh: Agustus 2025"
                                       required>
                            </div>
                        </div>

                        <!-- Total Preview - Responsive -->
                        <div class="mb-8 p-4 sm:p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <!-- Left Content -->
                                <div class="flex items-start sm:items-center">
                                    <div class="w-10 h-10 sm:w-10 sm:h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base sm:text-lg font-semibold text-green-800">Total per Siswa</h4>
                                        <p class="text-xs sm:text-sm text-green-600 mt-0.5">Jumlah tagihan yang akan dibuat untuk setiap siswa</p>
                                    </div>
                                </div>
                                
                                <!-- Right Content - Total Amount -->
                                <div class="text-left sm:text-right pl-13 sm:pl-0">
                                    <div id="totalAmount" class="text-xl sm:text-2xl font-bold text-green-800">Rp 0</div>
                                    <div class="text-xs text-green-600 mt-0.5">Akan diperbarui otomatis</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 hover:scale-105">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Simpan Tagihan
                            </button>
                            <a href="{{ route('staf.pembayaran.index') }}" 
                               class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="number"]');
    const totalElement = document.getElementById('totalAmount');
    
    function calculateTotal() {
        let total = 0;
        inputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });
        
        totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
    
    inputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
        input.addEventListener('keyup', calculateTotal);
    });
});
</script>

@endsection