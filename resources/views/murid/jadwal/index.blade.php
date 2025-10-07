@extends('layouts.app')

@section('title', 'Akademik')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4 py-6 sm:py-8">
        
        

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl shadow-sm p-1 mb-6 inline-flex gap-1">
            <button id="tab-jadwal" class="tab-btn px-6 py-2.5 rounded-lg font-medium text-sm transition-all duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Jadwal Pelajaran
            </button>
            <button id="tab-nilai" class="tab-btn px-6 py-2.5 rounded-lg font-medium text-sm transition-all duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Nilai Siswa
            </button>
        </div>
        
        <!-- Jadwal Content -->
        <div id="content-jadwal" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($jadwalList as $jadwal)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 overflow-hidden transition-all duration-200 hover:-translate-y-1">
                    
                    <!-- Header with Color Strip -->
                    <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-4 py-3">
                        <h3 class="text-white font-semibold text-base line-clamp-2">{{ $jadwal->mapel }}</h3>
                    </div>

                    <!-- Body -->
                    <div class="p-4 space-y-3">
                        <!-- Time Badge -->
                        <div class="inline-flex items-center px-3 py-1.5 bg-green-50 rounded-lg">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-green-700">
                                @php
                                    try {
                                        $jamMulai = \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai)->format('H:i');
                                        $jamSelesai = \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai)->format('H:i');
                                    } catch (Exception $e) {
                                        $jamMulai = $jadwal->jam_mulai;
                                        $jamSelesai = $jadwal->jam_selesai;
                                    }
                                @endphp
                                {{ $jamMulai }} - {{ $jamSelesai }}
                            </span>
                        </div>

                        <!-- Info List -->
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-700">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span>{{ ucfirst($jadwal->hari) }}</span>
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-700">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="truncate">{{ $jadwal->guru }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-semibold mb-1">Belum Ada Jadwal</h3>
                        <p class="text-gray-500 text-sm">Jadwal pelajaran akan ditampilkan di sini</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Nilai Content -->
        <div id="content-nilai" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $nilaiPublish = $nilaiList->where('status', 'publish');
                @endphp
                @forelse($nilaiPublish as $nilai)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 overflow-hidden transition-all duration-200 hover:-translate-y-1">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-3">
                        <h3 class="text-white font-semibold text-base line-clamp-2 mb-2">{{ $nilai->mapel }}</h3>
                        <span class="inline-flex items-center px-2.5 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-xs font-medium text-white">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            {{ $nilai->kelas }}
                        </span>
                    </div>

                    <!-- Body -->
                    <div class="p-4 space-y-3">
                        <!-- Nilai Grid -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">Tugas</p>
                                <p class="text-xl font-bold text-gray-900">{{ $nilai->nilai_tugas }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">UTS</p>
                                <p class="text-xl font-bold text-gray-900">{{ $nilai->nilai_uts }}</p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-600 mb-1">UAS</p>
                                <p class="text-xl font-bold text-gray-900">{{ $nilai->nilai_uas }}</p>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div class="pt-3 border-t border-gray-100">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Dipublikasi
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-gray-900 font-semibold mb-1">Belum Ada Nilai</h3>
                        <p class="text-gray-500 text-sm">Nilai akan ditampilkan setelah guru mempublikasikan</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    const tabJadwal = document.getElementById('tab-jadwal');
    const tabNilai = document.getElementById('tab-nilai');
    const contentJadwal = document.getElementById('content-jadwal');
    const contentNilai = document.getElementById('content-nilai');

    // Set initial active state
    tabJadwal.classList.add('bg-green-600', 'text-white');
    tabJadwal.classList.remove('text-gray-600', 'hover:bg-gray-50');
    
    tabNilai.classList.add('text-gray-600', 'hover:bg-gray-50');
    tabNilai.classList.remove('bg-green-600', 'text-white');

    function switchTab(activeTab, inactiveTab, activeContent, inactiveContent) {
        // Update tab styles
        activeTab.classList.add('bg-green-600', 'text-white');
        activeTab.classList.remove('text-gray-600', 'hover:bg-gray-50');
        
        inactiveTab.classList.remove('bg-green-600', 'text-white');
        inactiveTab.classList.add('text-gray-600', 'hover:bg-gray-50');
        
        // Update content visibility
        activeContent.classList.remove('hidden');
        inactiveContent.classList.add('hidden');
    }

    tabJadwal.addEventListener('click', () => {
        switchTab(tabJadwal, tabNilai, contentJadwal, contentNilai);
    });

    tabNilai.addEventListener('click', () => {
        switchTab(tabNilai, tabJadwal, contentNilai, contentJadwal);
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection