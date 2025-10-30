@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50">
    <div class="container mx-auto max-w-7xl px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">

        <!-- Header Section -->
        <div class="text-center mb-6 sm:mb-8 lg:mb-10">
            <div class="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mb-3 sm:mb-4 shadow-lg">
                <i class="fa-solid fa-calendar-days text-white text-lg sm:text-xl lg:text-2xl"></i>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-4xl font-bold text-gray-800 mb-2">Jadwal Mengajar</h1>
            <div class="flex items-center justify-center gap-2 text-gray-600">
                <i class="fa-solid fa-user-tie text-green-600 text-sm sm:text-base"></i>
                <p class="text-xs sm:text-sm lg:text-base">Selamat datang, <span class="font-semibold text-green-700">{{ Auth::user()->name }}</span></p>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-6 sm:mb-8">
            <!-- Hari Ini -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-xl border border-gray-100 p-4 sm:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-calendar-day text-blue-600 text-lg sm:text-xl lg:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800 mb-0.5">Hari Ini</h3>
                        <p class="text-2xl sm:text-3xl lg:text-4xl font-bold text-blue-600">{{ count($jadwalHariIni) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Jadwal mengajar</p>
                    </div>
                </div>
            </div>
            
            <!-- Minggu Ini -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-xl border border-gray-100 p-4 sm:p-5 lg:p-6 transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-calendar-week text-green-600 text-lg sm:text-xl lg:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800 mb-0.5">Minggu Ini</h3>
                        <p class="text-2xl sm:text-3xl lg:text-4xl font-bold text-green-600">{{ count($jadwalMingguIni) }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Total jadwal</p>
                    </div>
                </div>
            </div>
            
            <!-- Kelas Aktif -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-md hover:shadow-xl border border-gray-100 p-4 sm:p-5 lg:p-6 sm:col-span-2 lg:col-span-1 transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-graduation-cap text-purple-600 text-lg sm:text-xl lg:text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800 mb-0.5">Kelas Aktif</h3>
                        <p class="text-2xl sm:text-3xl lg:text-4xl font-bold text-purple-600">{{ collect($jadwalMingguIni)->pluck('kelas')->unique()->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500">Kelas yang diampu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-green-100 overflow-hidden mb-6 sm:mb-8">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-calendar-day text-white text-base sm:text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg lg:text-xl font-bold text-white">Jadwal Hari Ini</h2>
                            <p class="text-green-100 text-xs sm:text-sm">{{ $hariNow }}</p>
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <div class="text-white text-sm sm:text-base lg:text-lg font-semibold">
                            {{ $now->translatedFormat('d M Y') }}
                        </div>
                        <div class="text-green-100 text-xs sm:text-sm">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $now->format('H:i') }} WIB
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule Content -->
            <div class="p-0">
                <!-- Mobile View (Cards) -->
                <div class="block sm:hidden divide-y divide-gray-100">
                    @forelse($jadwalHariIni as $index => $jadwal)
                        <div class="p-4 hover:bg-green-50 transition-colors">
                            <!-- Time Badge -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-clock text-green-600 text-xs"></i>
                                    <span class="font-semibold text-green-800 text-xs">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="inline-flex items-center gap-2 bg-purple-100 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-users text-purple-600 text-xs"></i>
                                    <span class="font-semibold text-purple-800 text-xs">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                </div>
                            </div>
                            
                            <!-- Subject -->
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-book text-blue-600 text-sm"></i>
                                </div>
                                <span class="font-semibold text-gray-800 text-sm">{{ strtoupper($jadwal->mapel) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                <p class="text-gray-400 text-sm">Tidak ada jadwal mengajar hari ini</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Tablet & Desktop View (Table) -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-clock text-green-600 mr-2"></i>
                                    Waktu
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-book-open text-green-600 mr-2"></i>
                                    Mata Pelajaran
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-graduation-cap text-green-600 mr-2"></i>
                                    Kelas
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($jadwalHariIni as $index => $jadwal)
                                <tr class="hover:bg-green-50 transition-all duration-200 {{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-2 rounded-lg">
                                            <i class="fa-solid fa-clock text-green-600 text-sm"></i>
                                            <span class="font-semibold text-green-800 text-sm">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-book text-blue-600 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">{{ strtoupper($jadwal->mapel) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 bg-purple-100 px-3 py-2 rounded-lg">
                                            <i class="fa-solid fa-users text-purple-600 text-sm"></i>
                                            <span class="font-semibold text-purple-800 text-sm">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                            <p class="text-gray-400 text-sm">Tidak ada jadwal mengajar hari ini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Weekly Schedule Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-green-100 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-calendar-week text-white text-base sm:text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg lg:text-xl font-bold text-white">Jadwal Mingguan</h2>
                        <p class="text-green-100 text-xs sm:text-sm">Semua jadwal mengajar minggu ini</p>
                    </div>
                </div>
            </div>

            <!-- Weekly Schedule Content -->
            <div class="p-0">
                <!-- Mobile View (Cards) -->
                <div class="block md:hidden divide-y divide-gray-100">
                    @php
                        $hariColors = [
                            'senin' => ['bg' => 'red', 'text' => 'red'],
                            'selasa' => ['bg' => 'orange', 'text' => 'orange'], 
                            'rabu' => ['bg' => 'yellow', 'text' => 'yellow'],
                            'kamis' => ['bg' => 'green', 'text' => 'green'],
                            'jumat' => ['bg' => 'blue', 'text' => 'blue'],
                            'sabtu' => ['bg' => 'indigo', 'text' => 'indigo'],
                            'minggu' => ['bg' => 'purple', 'text' => 'purple']
                        ];
                    @endphp
                    @forelse($jadwalMingguIni as $index => $jadwal)
                        @php
                            $colors = $hariColors[strtolower($jadwal->hari)] ?? ['bg' => 'gray', 'text' => 'gray'];
                        @endphp
                        <div class="p-4 hover:bg-green-50 transition-colors">
                            <!-- Day & Time -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="inline-flex items-center gap-2 bg-{{ $colors['bg'] }}-100 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-calendar-day text-{{ $colors['text'] }}-600 text-xs"></i>
                                    <span class="font-semibold text-{{ $colors['text'] }}-800 capitalize text-xs">{{ $jadwal->hari }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-clock text-green-600 text-xs"></i>
                                    <span class="font-semibold text-green-800 text-xs">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Subject & Class -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-book text-blue-600 text-sm"></i>
                                    </div>
                                    <span class="font-semibold text-gray-800 text-sm">{{ strtoupper($jadwal->mapel) }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 bg-purple-100 px-3 py-1.5 rounded-lg">
                                    <i class="fa-solid fa-users text-purple-600 text-xs"></i>
                                    <span class="font-semibold text-purple-800 text-xs">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                                </div>
                                <h3 class="text-base font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                <p class="text-gray-400 text-sm">Belum ada jadwal mengajar minggu ini</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Tablet & Desktop View (Table) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-calendar text-green-600 mr-2"></i>
                                    Hari
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-clock text-green-600 mr-2"></i>
                                    Waktu
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-book-open text-green-600 mr-2"></i>
                                    Mata Pelajaran
                                </th>
                                <th class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fa-solid fa-graduation-cap text-green-600 mr-2"></i>
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
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 bg-{{ $color }}-100 px-3 py-2 rounded-lg">
                                            <i class="fa-solid fa-calendar-day text-{{ $color }}-600 text-sm"></i>
                                            <span class="font-semibold text-{{ $color }}-800 capitalize text-sm">{{ $jadwal->hari }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 bg-green-100 px-3 py-2 rounded-lg">
                                            <i class="fa-solid fa-clock text-green-600 text-sm"></i>
                                            <span class="font-semibold text-green-800 text-sm">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-book text-blue-600 text-sm"></i>
                                            </div>
                                            <span class="font-semibold text-gray-800 text-sm">{{ strtoupper($jadwal->mapel) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 text-center">
                                        <div class="inline-flex items-center gap-2 bg-purple-100 px-3 py-2 rounded-lg">
                                            <i class="fa-solid fa-users text-purple-600 text-sm"></i>
                                            <span class="font-semibold text-purple-800 text-sm">{{ strtoupper($jadwal->kelas->nama_kelas) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                                <i class="fa-solid fa-calendar-xmark text-gray-400 text-xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-600">Tidak Ada Jadwal</h3>
                                            <p class="text-gray-400 text-sm">Belum ada jadwal mengajar minggu ini</p>
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
</div>

<style>
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }
    
    /* Smooth transitions */
    tr, .hover\:bg-green-50 {
        transition: all 0.2s ease-in-out;
    }
    
    /* Enhanced hover effects */
    .hover\:-translate-y-1:hover {
        transform: translateY(-4px);
    }
    
    /* Responsive font scaling */
    @media (max-width: 374px) {
        html {
            font-size: 14px;
        }
    }
    
    /* Better spacing on small screens */
    @media (max-width: 640px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }
    
    /* Accessibility: Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
    
    /* Print styles */
    @media print {
        .bg-gradient-to-br,
        .bg-gradient-to-r {
            background: white !important;
        }
        
        .shadow-lg, .shadow-xl {
            box-shadow: none !important;
        }
    }
</style>
@endsection