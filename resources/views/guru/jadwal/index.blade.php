@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mb-4">
                <i class="fa-solid fa-calendar-days text-white text-xl sm:text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Jadwal Mengajar</h1>
            <div class="flex items-center justify-center gap-2 text-gray-600">
                <i class="fa-solid fa-user-tie text-green-600"></i>
                <p class="text-sm sm:text-base">Selamat datang, <span class="font-semibold text-green-700">{{ Auth::user()->name }}</span></p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mt-6 sm:mt-8 mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-calendar-day text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Hari Ini</h3>
                        <p class="text-xl sm:text-2xl font-bold text-blue-600">{{ count($jadwalHariIni) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Jadwal mengajar</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 sm:p-6">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-calendar-week text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Minggu Ini</h3>
                        <p class="text-xl sm:text-2xl font-bold text-green-600">{{ count($jadwalMingguIni) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Total jadwal</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 sm:p-6 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800">Kelas Aktif</h3>
                        <p class="text-xl sm:text-2xl font-bold text-purple-600">{{ collect($jadwalMingguIni)->pluck('kelas')->unique()->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Kelas yang diampu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden mb-6 sm:mb-8">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-calendar-day text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-white">Jadwal Hari Ini</h2>
                            <p class="text-green-100 text-sm">{{ $hariNow }}</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <div class="text-white text-base sm:text-lg font-semibold">
                            {{ $now->translatedFormat('d M Y') }}
                        </div>
                        <div class="text-green-100 text-sm">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $now->format('H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[600px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-clock text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Waktu
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-book-open text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Mata Pelajaran
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-graduation-cap text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Kelas
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($jadwalHariIni as $index => $jadwal)
                            <tr class="hover:bg-green-50 transition-all duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-green-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-clock text-green-600 text-xs sm:text-sm"></i>
                                        <span class="font-semibold text-green-800 text-xs sm:text-sm">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 max-w-full">
                                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-book text-blue-600 text-xs sm:text-sm"></i>
                                        </div>
                                        <span class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ strtoupper($jadwal->mapel) }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-purple-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-users text-purple-600 text-xs sm:text-sm"></i>
                                        <span class="font-semibold text-purple-800 text-xs sm:text-sm">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 sm:py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-calendar-xmark text-gray-400 text-lg sm:text-xl"></i>
                                        </div>
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                        <p class="text-gray-400 text-xs sm:text-sm">Tidak ada jadwal mengajar hari ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weekly Schedule Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-calendar-week text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-white">Jadwal Mingguan</h2>
                        <p class="text-green-100 text-xs sm:text-sm">Semua jadwal mengajar minggu ini</p>
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-calendar text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Hari
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-clock text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Waktu
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-book-open text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Mata Pelajaran
                            </th>
                            <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fa-solid fa-graduation-cap text-green-600 mr-1 sm:mr-2 hidden sm:inline"></i>
                                Kelas
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $hariColors = [
                                'senin' => 'red',
                                'selasa' => 'orange', 
                                'rabu' => 'yellow',
                                'kamis' => 'green',
                                'jumat' => 'blue',
                                'sabtu' => 'indigo',
                                'minggu' => 'purple'
                            ];
                        @endphp
                        @forelse($jadwalMingguIni as $index => $jadwal)
                            @php
                                $color = $hariColors[strtolower($jadwal->hari)] ?? 'gray';
                            @endphp
                            <tr class="hover:bg-green-50 transition-all duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-{{ $color }}-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-calendar-day text-{{ $color }}-600 text-xs sm:text-sm"></i>
                                        <span class="font-semibold text-{{ $color }}-800 capitalize text-xs sm:text-sm">{{ $jadwal->hari }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-green-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-clock text-green-600 text-xs sm:text-sm"></i>
                                        <span class="font-semibold text-green-800 text-xs sm:text-sm">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 max-w-full">
                                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-book text-blue-600 text-xs sm:text-sm"></i>
                                        </div>
                                        <span class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ strtoupper($jadwal->mapel) }}</span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                    <div class="inline-flex items-center gap-1 sm:gap-2 bg-purple-100 px-2 sm:px-3 py-1 sm:py-2 rounded-lg">
                                        <i class="fa-solid fa-users text-purple-600 text-xs sm:text-sm"></i>
                                        <span class="font-semibold text-purple-800 text-xs sm:text-sm">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 sm:py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fa-solid fa-calendar-xmark text-gray-400 text-lg sm:text-xl"></i>
                                        </div>
                                        <h3 class="text-base sm:text-lg font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                        <p class="text-gray-400 text-xs sm:text-sm">Belum ada jadwal mengajar minggu ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        
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
    
    /* Smooth transitions */
    tr {
        transition: all 0.2s ease-in-out;
    }
    
    .hover\:bg-green-50:hover {
        background-color: #f0fdf4;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .truncate {
            max-width: 100px;
        }
        
        /* Compact table styling */
        table th, table td {
            padding: 0.5rem 0.75rem;
        }
        
        /* Better badge sizing */
        .inline-flex.items-center.gap-1 {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
    
    /* Tablet optimizations */
    @media (min-width: 641px) and (max-width: 1024px) {
        .truncate {
            max-width: 150px;
        }
    }
    
    /* Enhanced accessibility */
    @media (prefers-reduced-motion: reduce) {
        .transition-all,
        .transform,
        .hover\\:bg-green-50:hover {
            transition: none;
            transform: none;
        }
    }
</style>
@endsection