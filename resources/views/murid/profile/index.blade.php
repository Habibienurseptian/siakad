@extends('layouts.app')
@section('title', 'Profil Murid')
@section('content')
<div class="min-h-screen bg-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Profile Card -->
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="relative bg-gradient-to-br from-green-500 to-emerald-600 px-6 pt-8 pb-24">
                <div class="flex justify-end">
                    <a href="{{ route('murid.profile.edit') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-medium px-4 py-2 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            <!-- Profile Image & Name -->
            <div class="px-6 pb-8">
                <div class="flex flex-col items-center -mt-20">
                    <div class="relative">
                        @if($murid->profile_image && file_exists(storage_path('app/public/' . $murid->profile_image)))
                            <img src="{{ asset('storage/' . $murid->profile_image) }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                        @else
                            <img src="{{ asset('images/user.png') }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                        @endif
                        <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-gray-900 mt-4 uppercase">{{ auth()->user()->name }}</h1>
                    <p class="text-gray-500 text-sm mt-1">{{ auth()->user()->email }}</p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 my-8"></div>

                <!-- Info Sections -->
                <div class="space-y-8">
                    <!-- Data Pribadi -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Data Pribadi</h2>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">NIS</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->nomor_induk ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Tempat Lahir</span>
                                <span class="text-sm font-medium text-gray-900 text-right uppercase">{{ $murid->tempat_lahir ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Tanggal Lahir</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->tanggal_lahir ? date('d-m-Y', strtotime($murid->tanggal_lahir)) : '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Warga Negara</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->warga_negara ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">No. Telepon</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>

                    <!-- Data Orang Tua -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Data Orang Tua/Wali</h2>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Nama</span>
                                <span class="text-sm font-medium text-gray-900 text-right uppercase">{{ $murid->nama_orangtua ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Tempat Lahir</span>
                                <span class="text-sm font-medium text-gray-900 text-right uppercase">{{ $murid->tempat_lahir_orangtua ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Tanggal Lahir</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->tanggal_lahir_orangtua ? date('d-m-Y', strtotime($murid->tanggal_lahir_orangtua)) : '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">No. Telepon</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->telepon_orangtua ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>

                    <!-- Alamat -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">Alamat</h2>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="py-2">
                                <span class="text-sm text-gray-500 block mb-1">Alamat Lengkap</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->alamat ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-50"></div>
                            
                            <div class="flex justify-between py-2">
                                <span class="text-sm text-gray-500">Kode Pos</span>
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $murid->kode_pos ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection