@extends('layouts.app')

@section('title', 'Edit Nilai Siswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto max-w-4xl px-4 py-8">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full mb-4">
                <i class="fa-solid fa-user-pen text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Nilai Siswa</h1>
            <p class="text-gray-600">Perbarui nilai siswa dengan mudah dan akurat</p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-edit text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Form Edit Nilai</h2>
                        <p class="text-orange-100">Ubah nilai sesuai dengan penilaian terbaru</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                <form action="{{ route('guru.nilai.update', $nilai->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Student Information Section -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-blue-700 mb-6">
                            <i class="fa-solid fa-user-graduate"></i>
                            Informasi Siswa
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Student Name -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <i class="fa-solid fa-user text-blue-600"></i>
                                    Nama Siswa
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           class="w-full text-center rounded-xl border-2 border-blue-200 bg-blue-50 py-3 px-4 font-semibold text-blue-800 cursor-not-allowed"
                                           value="{{ $murid->user->name ?? '-' }}" 
                                           readonly>
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fa-solid fa-lock text-blue-400"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Student ID -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <i class="fa-solid fa-id-card text-green-600"></i>
                                    Nomor Induk Siswa
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           class="w-full text-center rounded-xl border-2 border-green-200 bg-green-50 py-3 px-4 font-semibold text-green-800 cursor-not-allowed"
                                           value="{{ $murid->nomor_induk }}" 
                                           readonly>
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fa-solid fa-lock text-green-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grades Section -->
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                        <h3 class="flex items-center gap-2 text-lg font-bold text-purple-700 mb-6">
                            <i class="fa-solid fa-star"></i>
                            Nilai Siswa
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Assignment Grade -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <i class="fa-solid fa-tasks text-orange-600"></i>
                                    Nilai Tugas
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_tugas" 
                                           min="0" 
                                           max="100" 
                                           class="w-full text-center rounded-xl border-2 border-orange-200 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 py-4 px-4 text-2xl font-bold text-orange-800 bg-orange-50"
                                           value="{{ old('nilai_tugas', $nilai->nilai_tugas) }}"
                                           placeholder="0">
                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-pencil text-white text-xs"></i>
                                    </div>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fa-solid fa-clipboard-list text-orange-400"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="inline-flex items-center gap-1 bg-orange-100 px-3 py-1 rounded-full text-xs font-semibold text-orange-700">
                                        <i class="fa-solid fa-info-circle"></i>
                                        Rentang: 0-100
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Midterm Grade -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <i class="fa-solid fa-file-alt text-yellow-600"></i>
                                    Nilai UTS
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_uts" 
                                           min="0" 
                                           max="100" 
                                           class="w-full text-center rounded-xl border-2 border-yellow-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 py-4 px-4 text-2xl font-bold text-yellow-800 bg-yellow-50"
                                           value="{{ old('nilai_uts', $nilai->nilai_uts) }}"
                                           placeholder="0">
                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-pencil text-white text-xs"></i>
                                    </div>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fa-solid fa-book text-yellow-400"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="inline-flex items-center gap-1 bg-yellow-100 px-3 py-1 rounded-full text-xs font-semibold text-yellow-700">
                                        <i class="fa-solid fa-info-circle"></i>
                                        Ujian Tengah Semester
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Final Grade -->
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                    <i class="fa-solid fa-trophy text-red-600"></i>
                                    Nilai UAS
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_uas" 
                                           min="0" 
                                           max="100" 
                                           class="w-full text-center rounded-xl border-2 border-red-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 py-4 px-4 text-2xl font-bold text-red-800 bg-red-50"
                                           value="{{ old('nilai_uas', $nilai->nilai_uas) }}"
                                           placeholder="0">
                                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-pencil text-white text-xs"></i>
                                    </div>
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <i class="fa-solid fa-medal text-red-400"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <span class="inline-flex items-center gap-1 bg-red-100 px-3 py-1 rounded-full text-xs font-semibold text-red-700">
                                        <i class="fa-solid fa-info-circle"></i>
                                        Ujian Akhir Semester
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                        <a href="{{ route('guru.nilai.index') }}" 
                           class="inline-flex items-center justify-center gap-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fa-solid fa-arrow-left"></i>
                            Batal
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200">
                            <i class="fa-solid fa-save"></i>
                            Perbarui Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-tasks text-orange-600"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Nilai Tugas Saat Ini</h3>
                <p class="text-2xl font-bold text-orange-600">{{ $nilai->nilai_tugas }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-file-alt text-yellow-600"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Nilai UTS Saat Ini</h3>
                <p class="text-2xl font-bold text-yellow-600">{{ $nilai->nilai_uts }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-trophy text-red-600"></i>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Nilai UAS Saat Ini</h3>
                <p class="text-2xl font-bold text-red-600">{{ $nilai->nilai_uas }}</p>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="bg-blue-50 rounded-2xl border border-blue-200 p-6 mt-8">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i class="fa-solid fa-lightbulb text-white text-sm"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-800 mb-2">Tips Penilaian</h3>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-blue-500"></i>
                            Pastikan nilai yang dimasukkan sudah sesuai dengan kriteria penilaian
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-blue-500"></i>
                            Periksa kembali setiap nilai sebelum menyimpan perubahan
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check-circle text-blue-500"></i>
                            Nilai yang sudah disimpan akan langsung terlihat oleh siswa
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced input styling */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
    }
    
    /* Input focus animations */
    input:focus {
        transform: scale(1.02);
        transition: all 0.2s ease-in-out;
    }
    
    /* Button hover effects */
    button:hover, a:hover {
        transform: scale(1.05);
        transition: all 0.2s ease-in-out;
    }
    
    /* Card hover effects */
    .bg-white:hover {
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out;
    }
    
    /* Gradient text effect */
    .gradient-text {
        background: linear-gradient(135deg, #10b981, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>
@endsection