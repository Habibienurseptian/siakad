@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mb-4">
                <i class="fa-solid fa-pen-to-square text-white text-xl sm:text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2 px-4">Input Nilai Siswa</h1>
            <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto px-4">Silakan pilih mata pelajaran dan kelas untuk memasukkan nilai siswa</p>
        </div>

        <!-- Filter Section -->
        <form action="{{ route('guru.nilai.index') }}" method="GET" class="bg-white rounded-2xl shadow-lg border border-green-100 p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8">
            <div class="flex items-center gap-3 mb-4 sm:mb-6">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-filter text-green-600 text-sm sm:text-base"></i>
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Mata Pelajaran & Kelas</h2>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
                <div class="space-y-2">
                    <label for="mapel" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-book text-blue-600"></i>
                        Mata Pelajaran
                    </label>
                    <select name="mapel" id="mapel" class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 py-3 px-4 text-gray-700 text-sm sm:text-base" onchange="this.form.submit()">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel }}" {{ request('mapel') == $mapel ? 'selected' : '' }}>{{ $mapel }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label for="kelas" class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                        <i class="fa-solid fa-graduation-cap text-purple-600"></i>
                        Kelas
                    </label>
                    <select name="kelas" id="kelas" class="w-full rounded-xl border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 py-3 px-4 text-gray-700 text-sm sm:text-base" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if($mapelSelected && $kelasSelected)
        <!-- Grade Input Form -->
        <form action="{{ route('guru.nilai.store') }}" method="POST" class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden mb-6 sm:mb-8" id="form-nilai">
            @csrf
            <input type="hidden" name="mapel" value="{{ $mapelSelected }}">
            <input type="hidden" name="kelas" value="{{ $kelasSelected }}">

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-users text-white text-lg sm:text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white">Daftar Siswa</h2>
                            <p class="text-green-100 text-sm sm:text-base">Kelas {{ $kelasSelected }} - {{ $mapelSelected }}</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 sm:px-4 py-2 rounded-lg self-start sm:self-auto">
                        <span class="text-white font-semibold text-sm sm:text-base">
                            <i class="fa-solid fa-user-graduate mr-2"></i>
                            {{ $muridList->count() }} Siswa
                        </span>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-id-card text-blue-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                NIS
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-user text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Nama Siswa
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-tasks text-orange-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                <span class="hidden sm:inline">Tugas (0-100)</span>
                                <span class="sm:hidden">Tugas</span>
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-file-alt text-yellow-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                <span class="hidden sm:inline">UTS (0-100)</span>
                                <span class="sm:hidden">UTS</span>
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-trophy text-red-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                <span class="hidden sm:inline">UAS (0-100)</span>
                                <span class="sm:hidden">UAS</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($muridList as $index => $murid)
                            @if(!$murid->sudahDinilai)
                                <tr class="hover:bg-green-50 transition-all duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <div class="inline-flex items-center gap-1 sm:gap-2 bg-blue-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                            <i class="fa-solid fa-id-card-clip text-blue-600 text-xs sm:text-sm hidden sm:inline"></i>
                                            <span class="font-semibold text-blue-800 text-xs sm:text-sm">{{ $murid->nomor_induk }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 max-w-full">
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-user text-green-600 text-xs sm:text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ $murid->user?->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <input type="number" name="nilai_tugas[{{ $murid->id }}]" min="0" max="100" 
                                               class="w-16 sm:w-20 lg:w-24 text-center rounded-lg border-2 border-orange-200 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 py-1 sm:py-2 px-1 sm:px-3 font-semibold text-orange-800 text-xs sm:text-sm"
                                               placeholder="0">
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <input type="number" name="nilai_uts[{{ $murid->id }}]" min="0" max="100" 
                                               class="w-16 sm:w-20 lg:w-24 text-center rounded-lg border-2 border-yellow-200 focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 py-1 sm:py-2 px-1 sm:px-3 font-semibold text-yellow-800 text-xs sm:text-sm"
                                               placeholder="0">
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <input type="number" name="nilai_uas[{{ $murid->id }}]" min="0" max="100" 
                                               class="w-16 sm:w-20 lg:w-24 text-center rounded-lg border-2 border-red-200 focus:ring-2 focus:ring-red-500 focus:border-red-500 py-1 sm:py-2 px-1 sm:px-3 font-semibold text-red-800 text-xs sm:text-sm"
                                               placeholder="0">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @if(!$hasUngraded)
                            <tr>
                                <td colspan="5" class="px-6 py-8 sm:py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-check-circle text-green-600 text-lg sm:text-2xl"></i>
                                        </div>
                                        <h3 class="text-base sm:text-lg font-semibold text-green-600">Semua Siswa Sudah Dinilai</h3>
                                        <p class="text-gray-400 text-xs sm:text-sm">Tidak ada siswa yang perlu dinilai lagi</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if($hasUngraded)
            <!-- Submit Button -->
            <div class="bg-gray-50 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold px-6 sm:px-8 py-2 sm:py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 text-sm sm:text-base">
                        <i class="fa-solid fa-save"></i>
                        Simpan Nilai
                    </button>
                </div>
            </div>
            @endif
        </form>

        <!-- Publish Section -->
        @if($nilaiDraft->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-rocket text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Publikasi Nilai</h3>
                        <p class="text-gray-600 text-sm sm:text-base">{{ $nilaiDraft->count() }} nilai siap dipublikasikan</p>
                    </div>
                </div>
                <form action="{{ route('guru.nilai.publish') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <input type="hidden" name="mapel" value="{{ $mapelSelected }}">
                    <input type="hidden" name="kelas" value="{{ $kelasSelected }}">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-200 text-sm sm:text-base">
                        <i class="fa-solid fa-paper-plane"></i>
                        Publikasikan Nilai
                    </button>
                </form>
            </div>
            <div class="mt-4 p-3 sm:p-4 bg-blue-50 rounded-lg">
                <p class="text-xs sm:text-sm text-blue-700 flex items-center gap-2">
                    <i class="fa-solid fa-info-circle"></i>
                    Nilai yang dipublikasi akan terlihat oleh siswa dan orang tua
                </p>
            </div>
        </div>
        @endif

        <!-- Graded Students Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-check-double text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white">Siswa yang Sudah Dinilai</h2>
                            <p class="text-gray-200 text-sm sm:text-base">Daftar nilai yang telah diinput</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-20 px-3 sm:px-4 py-2 rounded-lg self-start sm:self-auto">
                        <span class="text-white font-semibold text-sm sm:text-base">
                            <i class="fa-solid fa-clipboard-check mr-2"></i>
                            {{ $muridSudahDinilai->count() }} Dinilai
                        </span>
                    </div>
                </div>
            </div>

            <!-- Graded Students Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-id-card text-blue-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                NIS
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-user text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Nama Siswa
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-tasks text-orange-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Tugas
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-file-alt text-yellow-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                UTS
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-trophy text-red-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                UAS
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-cogs text-purple-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($muridSudahDinilai as $index => $nilai)
                            <tr class="hover:bg-gray-50 transition-all duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-blue-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-id-card-clip text-blue-600 text-xs sm:text-sm hidden sm:inline"></i>
                                        <span class="font-semibold text-blue-800 text-xs sm:text-sm">{{ $nilai->murid->nomor_induk ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-2 max-w-full">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-green-600 text-xs sm:text-sm"></i>
                                        </div>
                                        <span class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ $nilai->murid->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-orange-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-star text-orange-600 text-xs sm:text-sm"></i>
                                        <span class="font-bold text-orange-800 text-xs sm:text-sm">{{ $nilai->nilai_tugas }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-yellow-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-star text-yellow-600 text-xs sm:text-sm"></i>
                                        <span class="font-bold text-yellow-800 text-xs sm:text-sm">{{ $nilai->nilai_uts }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-red-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-star text-red-600 text-xs sm:text-sm"></i>
                                        <span class="font-bold text-red-800 text-xs sm:text-sm">{{ $nilai->nilai_uas }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <a href="{{ route('guru.nilai.edit', $nilai->id) }}" 
                                       class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2 sm:px-3 py-1 sm:py-2 rounded-lg shadow transform hover:scale-105 transition-all duration-200">
                                        <i class="fa-solid fa-edit text-xs sm:text-sm"></i>
                                        <span class="text-[10px] sm:text-xs font-semibold hidden sm:inline">Edit</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 sm:py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-inbox text-gray-400 text-lg sm:text-2xl"></i>
                                        </div>
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-600">Belum Ada Nilai</h3>
                                        <p class="text-gray-400 text-xs sm:text-sm">Belum ada siswa yang dinilai</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @endif
    </div>
</div>

<style>
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }
    
    /* Enhanced input styling */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
    }
    
    /* Smooth transitions */
    tr {
        transition: all 0.2s ease-in-out;
    }
    
    .hover\:bg-green-50:hover {
        background-color: #f0fdf4;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Mobile specific optimizations */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        /* Compact spacing for mobile */
        .space-y-2 > * + * {
            margin-top: 0.5rem;
        }
        
        /* Touch-friendly inputs */
        input[type="number"] {
            min-height: 2.5rem;
            font-size: 14px;
        }
        
        /* Improved button sizing */
        button {
            min-height: 2.5rem;
            padding: 0.5rem 1rem;
        }
        
        /* Better text truncation */
        .truncate {
            max-width: 120px;
        }
        
        /* Compact badges */
        .inline-flex.items-center.gap-1 {
            padding: 0.25rem 0.5rem;
        }
    }
    
    /* Tablet optimizations */
    @media (min-width: 641px) and (max-width: 1024px) {
        .container {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        
        /* Better table spacing */
        table th, table td {
            padding: 0.75rem 1rem;
        }
        
        input[type="number"] {
            width: 5rem;
        }
    }
    
    /* Large screen optimizations */
    @media (min-width: 1025px) {
        /* Enhanced hover effects */
        tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Better input focus states */
        input[type="number"]:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    }
    
    /* Horizontal scroll indicator */
    .overflow-x-auto {
        position: relative;
    }
    
    .overflow-x-auto::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 20px;
        background: linear-gradient(to left, rgba(255,255,255,0.8), transparent);
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .overflow-x-auto:hover::after {
        opacity: 1;
    }
    
    /* Enhanced focus visibility */
    select:focus, input:focus, button:focus {
        outline: 2px solid #10b981;
        outline-offset: 2px;
    }
    
    /* Better loading states */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    /* Improved accessibility */
    @media (prefers-reduced-motion: reduce) {
        .transition-all,
        .transform,
        .hover\\:scale-105:hover {
            transition: none;
            transform: none;
        }
    }
</style>
@endsection