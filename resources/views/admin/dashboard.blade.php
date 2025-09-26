@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    // Mendapatkan waktu sekarang di zona Jakarta (WIB)
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

        <!-- Bubbles (hidden di mobile) -->
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
    <div class="bg-white shadow-md rounded-xl p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
            <span class="icon-card mr-3">
                <i class="fas fa-school text-white text-xl"></i>
            </span>
            Ringkasan Data Sekolah
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-green-600 p-2 rounded-lg bg-green-200">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-medium text-green-700">Total Sekolah</h3>
                </div>
                <p class="text-3xl font-extrabold text-green-900">{{ $data['totalSekolah'] ?? 0 }}</p>
            </div>

            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-blue-600 p-2 rounded-lg bg-blue-200">
                        <i class="fas fa-user-graduate text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-medium text-blue-700">Total Siswa</h3>
                </div>
                <p class="text-3xl font-extrabold text-blue-900">{{ $data['totalSiswa'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-indigo-600 p-2 rounded-lg bg-indigo-200">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-medium text-indigo-700">Total Guru</h3>
                </div>
                <p class="text-3xl font-extrabold text-indigo-900">{{ $data['totalGuru'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-purple-600 p-2 rounded-lg bg-purple-200">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-medium text-purple-700">Total Staf</h3>
                </div>
                <p class="text-3xl font-extrabold text-purple-900">{{ $data['totalStaf'] }}</p>
            </div>
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