@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    
    {{-- HERO --}}
    <div class="relative overflow-hidden shadow-xl rounded-lg p-8 text-white">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-green-800 via-green-700 to-green-800"></div>
        
        <div class="absolute top-0 left-1/4 w-40 h-40 bg-white opacity-20 rounded-full animate-bubble"></div>
        <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-white opacity-15 rounded-full animate-bubble delay-2000 hidden md:block"></div>
        <div class="absolute top-1/3 right-1/4 w-48 h-48 bg-white opacity-10 rounded-full animate-bubble delay-4000 hidden md:block"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full animate-bubble delay-4000"></div>
        <div class="absolute bottom-0 right-0 w-36 h-36 bg-white opacity-20 rounded-full animate-bubble delay-6000"></div>

        
        <p class="text-3xl font-semibold flex items-center">
            <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
            {{ $greeting }}
        </p>
        <p class="md:text-5xl text-2xl font-bold mt-4 flex items-center">
            {{ $userName }}👋
        </p>
        <p class="mt-4 text-gray-100 md:text-lg text-md flex items-center">
            <i class="fas fa-door-open mr-2"></i>
            Selamat datang di dashboard.
        </p>
    </div>

    {{-- JADWAL PELAJARAN --}}
    <div class="bg-gray-100 shadow-md rounded-lg p-6 mt-6">
        <h2 class="md:text-2xl text-xl font-semibold text-gray-900 flex items-center">
            <span class="icon-card mr-3">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </span>
            Jadwal Pelajaran Hari {{ $hariNow }}
        </h2>
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pb-4">
            @forelse($jadwalHariIni as $jadwal)
                <div class="relative p-5 bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-200 flex flex-col justify-between min-h-[160px]">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <span class="font-semibold text-gray-800 text-lg">{{ $jadwal->mapel }}</span>
                        </div>
                        <span class="text-sm text-gray-500 flex items-center">
                            <i class="far fa-clock mr-1"></i>
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </span>
                    </div>
                    <div>
                            <p class="text-gray-700 font-medium">Kelas {{ $jadwal->kelas ?? '-' }}</p>
                            <p class="text-gray-500 text-sm flex items-center mt-1">
                                <i class="fas fa-user-tie mr-1 text-gray-400"></i>
                                {{ $jadwal->guru }}
                            </p>
                    </div>
                </div>
            @empty
                <div class="p-5 bg-gray-50 rounded-md text-gray-400">Tidak ada jadwal pelajaran hari ini.</div>
            @endforelse
        </div>
    </div>

    {{-- PENGUMUMAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- PENGUMUMAN TERBARU --}}
        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <i class="fas fa-bullhorn text-white text-lg"></i>
                </span>
                Pengumuman Terbaru
            </h2>
            <ul class="mt-6 space-y-4 max-h-64 overflow-y-auto">
                @forelse($pengumuman_terbaru as $pengumuman)
                <li class="p-4 rounded-lg border bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <span class="flex-1 font-medium text-gray-800 break-words sm:whitespace-nowrap sm:overflow-hidden sm:text-ellipsis">
                            <i class="fas fa-newspaper text-green-600 mr-2"></i>
                            {{ $pengumuman->judul }}
                        </span>
                        <span class="text-xs text-gray-500 mt-1 sm:mt-0 sm:ml-auto flex-shrink-0">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $pengumuman->created_at->format('d-m-Y') }}
                        </span>
                    </div>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">{{ $pengumuman->isi }}</p>
                </li>
                @empty
                <li class="p-5 bg-gray-50 rounded-md text-gray-400">Belum ada pengumuman terbaru.</li>
                @endforelse
            </ul>
        </div>

        {{-- PENGUMUMAN AKADEMIK --}}
        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </span>
                Pengumuman Akademik
            </h2>
            <ul class="mt-6 space-y-4 max-h-64 overflow-y-auto">
                @forelse($pengumuman_akademik as $pengumuman)
                <li class="p-4 rounded-lg border bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <span class="flex-1 font-medium text-gray-800 break-words sm:whitespace-nowrap sm:overflow-hidden sm:text-ellipsis">
                            <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i> 
                            {{ $pengumuman->judul }}
                        </span>
                        <span class="text-xs text-gray-500 mt-1 sm:mt-0 sm:ml-auto flex-shrink-0">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $pengumuman->created_at->format('d-m-Y') }}
                        </span>
                    </div>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">{{ $pengumuman->isi }}</p>
                </li>
                @empty
                <li class="p-5 bg-gray-50 rounded-md text-gray-400">Belum ada pengumuman akademik.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<style>
    .icon-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to right, #14532D, #166534, #14532D);
        border-radius: 0.75rem;
        padding: 0.6rem;
        min-width: 48px;
        min-height: 48px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
</style>

@endsection