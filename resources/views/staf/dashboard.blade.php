@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-6">
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

    <!-- Ringkasan Data Sekolah -->
    <div class="bg-gray-100 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
            <span class="icon-card mr-3">
                <i class="fas fa-school text-white text-xl"></i>
            </span>
            Ringkasan Data Sekolah
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                <i class="fas fa-user-graduate text-4xl text-blue-600 mb-2"></i>
                <p class="mt-1 text-3xl font-extrabold text-blue-600">{{ $data['totalSiswa'] }}</p>
                <h2 class="text-base font-semibold text-gray-500">Total Siswa</h2>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                <i class="fas fa-chalkboard-teacher text-4xl text-green-600 mb-2"></i>
                <p class="mt-1 text-3xl font-extrabold text-green-600">{{ $data['totalGuru'] }}</p>
                <h2 class="text-base font-semibold text-gray-500">Total Guru</h2>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                <i class="fas fa-users text-4xl text-orange-600 mb-2"></i>
                <p class="mt-1 text-3xl font-extrabold text-orange-600">{{ $data['totalStaf'] }}</p>
                <h2 class="text-base font-semibold text-gray-500">Total Staf</h2>
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
        min-width: 48px;
        min-height: 48px;
    }
</style>
@endsection
