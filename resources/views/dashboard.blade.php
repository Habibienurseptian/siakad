@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $hour = now()->setTimezone('Asia/Jakarta')->format('H');

    if($hour < 12){
        $greeting = 'Selamat Pagi';
    } elseif($hour < 15){
        $greeting = 'Selamat Siang';
    } elseif($hour < 18){
        $greeting = 'Selamat Sore';
    } else {
        $greeting = 'Selamat Malam';
    }

    $userName = auth()->user()->name ?? 'Pengguna';
@endphp

<div class="container mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 py-8 space-y-6">
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

        <p class="text-5xl font-bold mt-4 flex items-center">
            {{ $userName }}!
        </p>

        <p class="mt-4 text-gray-100 text-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14v14H5V7z M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
            </svg>
            Selamat datang di dashboard.
        </p>
    </div>

    <!-- Ringkasan Data Sekolah -->
    <div class="bg-gray-100 shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="icon-card mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
            </span>
            Ringkasan Data Sekolah
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center"> <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-12 w-12 text-blue-600 mb-1"  fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" 
                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" 
                        clip-rule="evenodd" />
                </svg>
                <p class="mt-1 text-3xl font-extrabold text-blue-600">1,250</p> <h2 class="text-base font-semibold text-gray-500">Total Siswa</h2> </div>

            <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-12 w-12 text-green-600 mb-1" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zm-1.5 9a3 3 0 100-6 3 3 0 000 6z" />
                </svg>
                <p class="mt-1 text-3xl font-extrabold text-green-600">75</p>
                <h2 class="text-base font-semibold text-gray-500">Total Guru</h2>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="h-12 w-12 text-purple-600 mb-1" 
                    fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zm0 4a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM5 15a2 2 0 100-4h10a2 2 0 100 4H5z" />
                </svg>
                <p class="mt-1 text-3xl font-extrabold text-purple-600">25</p>
                <h2 class="text-base font-semibold text-gray-500">Total Kelas</h2>
            </div>
        </div>
    </div>

    <!--Jadwal Pelajaran-->
    <div class="bg-gray-100 shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-2xl font-semibold text-gray-900 flex items-center">
            <span class="icon-card mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
            Jadwal Pelajaran Hari Ini
        </h2>
        <div class="mt-6 flex flex-col md:flex-row gap-4 overflow-x-auto pb-4">
            <div class="p-5 bg-gray-50 rounded-md flex-none w-full md:w-1/3 min-w-[280px]">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-medium text-gray-800">Matematika</span>
                    <span class="text-sm text-gray-500">08:00 - 09:30</span>
                </div>
                <p class="mt-1 text-gray-600">Ruang 101 - Bapak Budi</p>
            </div>
            <div class="p-5 bg-gray-50 rounded-md flex-none w-full md:w-1/3 min-w-[280px]">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-medium text-gray-800">Bahasa Inggris</span>
                    <span class="text-sm text-gray-500">09:45 - 11:15</span>
                </div>
                <p class="mt-1 text-gray-600">Ruang 102 - Ibu Ani</p>
            </div>
            <div class="p-5 bg-gray-50 rounded-md flex-none w-full md:w-1/3 min-w-[280px]">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-medium text-gray-800">Istirahat</span>
                    <span class="text-sm text-gray-500">11:15 - 12:00</span>
                </div>
                <p class="mt-1 text-gray-600">Istirahat makan siang</p>
            </div>
            <div class="p-5 bg-gray-50 rounded-md flex-none w-full md:w-1/3 min-w-[280px]">
                <div class="flex items-center justify-between">
                    <span class="text-lg font-medium text-gray-800">Fisika</span>
                    <span class="text-sm text-gray-500">12:00 - 13:30</span>
                </div>
                <p class="mt-1 text-gray-600">Lab Fisika - Bapak Wawan</p>
            </div>
        </div>
    </div>

    <!--Pengumuman-->

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-gray-100 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                Pengumuman Terbaru
            </h2>
            <ul class="mt-6 space-y-6">
                <li class="p-5 bg-gray-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-800">Rapat Orang Tua</span>
                        <span class="text-sm text-gray-500">2023-10-26</span>
                    </div>
                    <p class="mt-2 text-gray-600">
                        Akan diadakan rapat orang tua untuk membahas kemajuan belajar siswa pada tanggal 28 Oktober 2023.
                    </p>
                </li>
                <li class="p-5 bg-gray-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-800">Jadwal Ujian</span>
                        <span class="text-sm text-gray-500">2023-10-25</span>
                    </div>
                    <p class="mt-2 text-gray-600">
                        Jadwal lengkap Ujian Akhir Semester telah dirilis. Silakan cek bagian dokumen.
                    </p>
                </li>
            </ul>
        </div>

        <div class="bg-gray-100 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 flex items-center">
                <span class="icon-card mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0c-4.418 0-8-1.79-8-4" />
                    </svg>
                </span>
                Pengumuman Akademik
            </h2>
            <ul class="mt-6 space-y-6">
                <li class="p-5 bg-gray-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-800">Deadline Penyerahan Tugas</span>
                        <span class="text-sm text-gray-500">2023-10-28</span>
                    </div>
                    <p class="mt-2 text-gray-600">
                        Semua siswa wajib menyerahkan tugas akhir mata pelajaran Matematika paling lambat tanggal 28 Oktober 2023.
                    </p>
                </li>
                <li class="p-5 bg-gray-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-800">Pengumuman Nilai Mid Semester</span>
                        <span class="text-sm text-gray-500">2023-10-27</span>
                    </div>
                    <p class="mt-2 text-gray-600">
                        Nilai Mid Semester telah tersedia di portal siswa. Silakan cek akun masing-masing.
                    </p>
                </li>
                <li class="p-5 bg-gray-50 rounded-md">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-medium text-gray-800">Workshop Online</span>
                        <span class="text-sm text-gray-500">2023-10-29</span>
                    </div>
                    <p class="mt-2 text-gray-600">
                        Siswa kelas 10 diwajibkan mengikuti workshop online tentang pengembangan skill akademik pada tanggal 29 Oktober 2023.
                    </p>
                </li>
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