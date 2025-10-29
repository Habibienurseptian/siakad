@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto w-full max-w-7xl px-3 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Hero Greeting -->
    <div class="relative overflow-hidden shadow-xl rounded-lg p-6 sm:p-8 text-white">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-green-800 via-green-700 to-green-800"></div>

        <!-- Bubble Decoration -->
        <div class="absolute top-0 left-1/4 w-32 h-32 bg-white opacity-20 rounded-full animate-bubble hidden sm:block"></div>
        <div class="absolute top-1/2 left-1/2 w-24 h-24 bg-white opacity-15 rounded-full animate-bubble delay-2000 hidden md:block"></div>
        <div class="absolute top-1/3 right-1/4 w-40 h-40 bg-white opacity-10 rounded-full animate-bubble delay-4000 hidden md:block"></div>

        <p class="text-2xl sm:text-3xl font-semibold flex items-center">
            <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
            {{ $greeting }}
        </p>

        <p class="text-2xl sm:text-4xl md:text-5xl font-bold mt-3 flex items-center flex-wrap">
            {{ $userName }} 👋
        </p>

        <p class="mt-3 text-gray-100 sm:text-lg text-base flex items-center flex-wrap">
            <i class="fas fa-door-open mr-2"></i>
            Selamat datang di dashboard.
        </p>
    </div>

    {{-- JADWAL PELAJARAN --}}
    <div class="bg-gray-100 shadow-md rounded-lg p-4 sm:p-6 mt-6">
        <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 flex items-center">
            <span class="icon-card mr-3">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
            </span>
            Jadwal Pelajaran Hari {{ $hariNow }}
        </h2>

        <!-- Wrapper scroll horizontal -->
        <div class="mt-6 overflow-x-auto pb-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            <div class="flex gap-4 min-w-max">
                @forelse($jadwalHariIni as $jadwal)
                    <div class="relative p-4 sm:p-5 bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-200 flex flex-col justify-between min-w-[240px] sm:min-w-[280px] md:min-w-[320px]">
                        <div class="flex items-center justify-between mb-3 flex-wrap gap-1">
                            <div class="flex items-center space-x-2">
                                <div class="p-2 rounded-full bg-green-100 text-green-600">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <span class="font-semibold text-gray-800 text-base sm:text-lg">{{ $jadwal->mapel }}</span>
                            </div>
                            <span class="text-xs sm:text-sm text-gray-500 flex items-center whitespace-nowrap">
                                <i class="far fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-700 font-medium text-sm sm:text-base">
                                Kelas {{ strtoupper($jadwal->kelas->nama_kelas ?? '-') }}
                            </p>
                            <p class="text-gray-500 text-xs sm:text-sm flex items-center mt-1">
                                <i class="fas fa-user-tie mr-1 text-gray-400"></i>
                                {{ $jadwal->guru }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-5 bg-gray-50 rounded-md text-gray-400 min-w-[280px]">
                        Tidak ada jadwal pelajaran hari ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PENGUMUMAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- PENGUMUMAN TERBARU --}}
        <div class="bg-white shadow-md rounded-xl p-5 sm:p-6 border border-gray-100">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <i class="fas fa-bullhorn text-white text-lg"></i>
                </span>
                Pengumuman Terbaru
            </h2>
            <ul class="mt-5 space-y-4 max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @forelse($pengumuman_terbaru as $pengumuman)
                <li class="p-4 rounded-lg border bg-gray-50 hover:bg-gray-100 transition text-sm sm:text-base">
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
        <div class="bg-white shadow-md rounded-xl p-5 sm:p-6 border border-gray-100">
            <h2 class="text-lg sm:text-xl font-bold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </span>
                Pengumuman Akademik
            </h2>
            <ul class="mt-5 space-y-4 max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                @forelse($pengumuman_akademik as $pengumuman)
                <li class="p-4 rounded-lg border bg-gray-50 hover:bg-gray-100 transition text-sm sm:text-base">
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
        box-shadow: 0 2px 8px rgba(16,185,129,0.10);
        padding: 0.5rem;
        min-width: 42px;
        min-height: 42px;
    }

    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 9999px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background-color: #f3f4f6;
    }
</style>
@endsection
