@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.guru.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors group">
                <i class="fa-solid fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-medium">Kembali ke Data Guru</span>
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 sm:px-8 py-8 sm:py-10">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <!-- Profile Image -->
                    <div class="relative group">
                        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full ring-4 ring-white shadow-xl overflow-hidden bg-white">
                            <img src="{{ $guru->profile_image ? asset('storage/' . $guru->profile_image) : asset('images/user.png') }}" 
                                 alt="Profile" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-lg">
                            <i class="fa-solid fa-chalkboard-user text-green-600 text-lg"></i>
                        </div>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="flex-1 text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            {{ $guru->user ? $guru->user->name : '-' }}
                        </h1>
                        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 text-green-100">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-envelope text-sm"></i>
                                <span class="text-sm">{{ $guru->user ? $guru->user->email : '-' }}</span>
                            </div>
                            <span class="hidden sm:inline">•</span>
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <i class="fa-solid fa-id-badge text-sm"></i>
                                <span class="text-sm font-medium">{{ $guru->nip ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Body -->
            <div class="p-6 sm:p-8">
                
                <!-- Quick Info Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-500 rounded-lg p-3">
                                <i class="fa-solid fa-school text-white text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-green-600 font-medium uppercase tracking-wide">Sekolah</p>
                                <p class="text-sm sm:text-base font-bold text-green-900 truncate">{{ $guru->sekolah ? $guru->sekolah->nama : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-4 border border-emerald-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-500 rounded-lg p-3">
                                <i class="fa-solid fa-heart text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-600 font-medium uppercase tracking-wide">Status Marital</p>
                                <p class="text-lg font-bold text-emerald-900">{{ strtoupper($guru->status_marital ?? '-') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Information -->
                <div class="space-y-6">
                    
                    <!-- Data Pribadi Section -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                            Data Pribadi
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tambahkan Jenis Kelamin di sini -->
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-venus-mars text-gray-400"></i>
                                    Jenis Kelamin
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->jenis_kelamin ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                                    Tempat Lahir
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->tempat_lahir ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-alt text-gray-400"></i>
                                    Tanggal Lahir
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->tanggal_lahir ? date('d F Y', strtotime($guru->tanggal_lahir)) : '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-flag text-gray-400"></i>
                                    Warga Negara
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->warga_negara ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-mailbox text-gray-400"></i>
                                    Kode Pos
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->kode_pos ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-gray-400"></i>
                                    Nomor Telepon
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->phone ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors md:col-span-2">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-home text-gray-400"></i>
                                    Alamat
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->alamat ?? '-') }}</dd>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua Section -->
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <div class="w-1 h-6 bg-emerald-500 rounded-full"></div>
                            Data Orang Tua
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors md:col-span-2">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-user text-gray-400"></i>
                                    Nama Orang Tua
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->nama_orangtua ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                                    Tempat Lahir
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->tempat_lahir_orangtua ?? '-') }}</dd>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-alt text-gray-400"></i>
                                    Tanggal Lahir
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">{{ strtoupper($guru->tanggal_lahir_orangtua ? date('d F Y', strtotime($guru->tanggal_lahir_orangtua)) : '-') }}</dd>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Action Footer -->
            <div class="bg-gray-50 px-6 sm:px-8 py-4 flex flex-col sm:flex-row gap-3 justify-end border-t border-gray-200">
                <a href="{{ route('admin.guru.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold rounded-lg text-gray-700 bg-white border-2 border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit Data</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection