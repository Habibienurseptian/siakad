@extends('layouts.app')

@section('title', 'Akademik')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-100">
    <div class="container mx-auto max-w-7xl px-3 sm:px-4 py-8 sm:py-12">
        <!-- Header Section -->
        <div class="text-center mb-8 sm:mb-10">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-green-800 mb-2">
                <i class="fas fa-graduation-cap mr-2 text-green-600"></i>
                Akademik
            </h1>
            <p class="text-green-600 text-sm sm:text-base">Jadwal Pelajaran dan Nilai Siswa</p>
        </div>

        <!-- Tabs -->
        <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4 mb-8 sm:mb-10">
            <button id="tab-jadwal" class="tab-btn bg-gradient-to-r from-green-600 to-green-700 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 border border-green-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span class="text-sm sm:text-base">Jadwal Pelajaran</span>
            </button>
            <button id="tab-nilai" class="tab-btn bg-white text-green-700 font-bold py-3 px-6 sm:px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 border border-green-200 hover:border-green-300">
                <i class="fas fa-clipboard-list mr-2"></i>
                <span class="text-sm sm:text-base">Nilai Siswa</span>
            </button>
        </div>
        
        <!-- Jadwal -->
        <div id="content-jadwal" class="bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-4 sm:p-6 lg:p-8 mb-8 border border-green-100">
            <div class="mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-green-800 flex items-center mb-2">
                    <i class="fas fa-calendar-week mr-3 text-green-600"></i>
                    Jadwal Pelajaran
                </h2>
                <div class="h-1 w-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse($jadwalList as $jadwal)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-5 sm:p-6 border-t-4 border-t-green-500 relative transform hover:scale-102 transition-all duration-300 hover:bg-green-50">
                    <!-- Decorative Corner -->
                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-bl-3xl rounded-tr-2xl opacity-60"></div>
                    
                    <!-- Header: Mapel + Jam -->
                    <div class="relative z-10 mb-4 sm:mb-5">
                        <h3 class="text-base sm:text-lg font-bold text-green-800 mb-3 flex items-start">
                            <div class="bg-green-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                <i class="fas fa-book text-green-600 text-sm"></i>
                            </div>
                            <span class="leading-tight break-words">{{ $jadwal->mapel }}</span>
                        </h3>
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs sm:text-sm font-bold px-3 sm:px-4 py-2 rounded-full shadow-md flex items-center justify-center w-fit">
                            <i class="far fa-clock mr-2"></i>
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
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="space-y-3">
                        <div class="flex items-center p-2 bg-green-50 rounded-lg">
                            <div class="bg-green-500 p-1.5 rounded-lg mr-3">
                                <i class="fas fa-calendar-day text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-green-800">{{ ucfirst($jadwal->hari) }}</span>
                        </div>
                        <div class="flex items-center p-2 bg-emerald-50 rounded-lg">
                            <div class="bg-emerald-500 p-1.5 rounded-lg mr-3">
                                <i class="fas fa-user-tie text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-green-700 break-words">{{ $jadwal->guru }}</span>
                        </div>
                        <!-- <div class="flex items-center p-2 bg-green-50 rounded-lg">
                            <div class="bg-green-600 p-1.5 rounded-lg mr-3">
                                <i class="fas fa-users text-white text-xs"></i>
                            </div>
                            <span class="text-sm font-medium text-green-800">{{ $jadwal->kelas }}</span>
                        </div> -->
                    </div>

                    <!-- Hover Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400/0 to-emerald-500/0 group-hover:from-green-400/5 group-hover:to-emerald-500/5 rounded-2xl transition-all duration-300"></div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 sm:py-20">
                    <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-green-500 text-2xl"></i>
                    </div>
                    <p class="text-green-600 font-medium text-sm sm:text-base">Tidak ada jadwal pelajaran yang ditemukan</p>
                    <p class="text-green-500 text-xs sm:text-sm mt-1">Jadwal akan ditampilkan setelah ditambahkan</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Nilai -->
        <div id="content-nilai" style="display:none;" class="bg-white/80 backdrop-blur-sm shadow-xl rounded-3xl p-4 sm:p-6 lg:p-8 mb-8 border border-green-100">
            <div class="mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-green-800 flex items-center mb-2">
                    <i class="fas fa-chart-line mr-3 text-green-600"></i>
                    Nilai Siswa
                </h2>
                <div class="h-1 w-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @php
                    $nilaiPublish = $nilaiList->where('status', 'publish');
                @endphp
                @forelse($nilaiPublish as $nilai)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-5 sm:p-6 border-t-4 border-t-emerald-500 relative transform hover:scale-102 transition-all duration-300 hover:bg-emerald-50">
                    <!-- Decorative Corner -->
                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-emerald-100 to-green-100 rounded-bl-3xl rounded-tr-2xl opacity-60"></div>
                    
                    <div class="relative z-10 mb-4 sm:mb-5">
                        <h3 class="text-base sm:text-lg font-bold text-green-800 mb-3 flex items-start">
                            <div class="bg-emerald-100 p-2 rounded-lg mr-3 flex-shrink-0">
                                <i class="fas fa-book-open text-emerald-600 text-sm"></i>
                            </div>
                            <span class="leading-tight break-words">{{ $nilai->mapel }}</span>
                        </h3>
                        <div class="bg-green-100 text-green-700 text-xs sm:text-sm font-bold px-3 sm:px-4 py-2 rounded-full flex items-center justify-center w-fit border border-green-200">
                            <i class="fas fa-users mr-2"></i>
                            {{ $nilai->kelas }}
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                            <div class="flex items-center">
                                <div class="bg-green-500 p-1.5 rounded-lg mr-3">
                                    <i class="fas fa-tasks text-white text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-green-700">Nilai Tugas</span>
                            </div>
                            <span class="text-green-800 font-bold text-base sm:text-lg bg-white px-3 py-1 rounded-lg shadow-sm">{{ $nilai->nilai_tugas }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl border border-emerald-100">
                            <div class="flex items-center">
                                <div class="bg-emerald-500 p-1.5 rounded-lg mr-3">
                                    <i class="fas fa-edit text-white text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-green-700">Nilai UTS</span>
                            </div>
                            <span class="text-green-800 font-bold text-base sm:text-lg bg-white px-3 py-1 rounded-lg shadow-sm">{{ $nilai->nilai_uts }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-100">
                            <div class="flex items-center">
                                <div class="bg-green-600 p-1.5 rounded-lg mr-3">
                                    <i class="fas fa-graduation-cap text-white text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-green-700">Nilai UAS</span>
                            </div>
                            <span class="text-green-800 font-bold text-base sm:text-lg bg-white px-3 py-1 rounded-lg shadow-sm">{{ $nilai->nilai_uas }}</span>
                        </div>

                        <div class="mt-4 pt-3 border-t border-green-100">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-sm">
                                <i class="fas fa-check-circle mr-1"></i>
                                Dipublikasi
                            </span>
                        </div>
                    </div>

                    <!-- Hover Effect -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-400/0 to-green-500/0 group-hover:from-emerald-400/5 group-hover:to-green-500/5 rounded-2xl transition-all duration-300"></div>
                </div>
                @empty
                <div class="col-span-full text-center py-16 sm:py-20">
                    <div class="bg-emerald-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-emerald-500 text-2xl"></i>
                    </div>
                    <p class="text-green-600 font-medium text-sm sm:text-base">Belum ada nilai yang dipublikasi</p>
                    <p class="text-green-500 text-xs sm:text-sm mt-1">Nilai akan ditampilkan setelah guru mempublikasikan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Tab Script with Enhanced Animations -->
<script>
    const tabJadwal = document.getElementById('tab-jadwal');
    const tabNilai = document.getElementById('tab-nilai');
    const contentJadwal = document.getElementById('content-jadwal');
    const contentNilai = document.getElementById('content-nilai');

    function setActiveTab(activeTab, inactiveTab, activeContent, inactiveContent) {
        // Active tab styling
        activeTab.classList.remove('bg-white', 'text-green-700', 'border-green-200');
        activeTab.classList.add('bg-gradient-to-r', 'from-green-600', 'to-green-700', 'text-white', 'border-green-500');
        
        // Inactive tab styling
        inactiveTab.classList.remove('bg-gradient-to-r', 'from-green-600', 'to-green-700', 'text-white', 'border-green-500');
        inactiveTab.classList.add('bg-white', 'text-green-700', 'border-green-200');
        
        // Content visibility with fade effect
        inactiveContent.style.opacity = '0';
        setTimeout(() => {
            activeContent.style.display = 'block';
            inactiveContent.style.display = 'none';
            activeContent.style.opacity = '1';
        }, 150);
    }

    // Add smooth transitions
    contentJadwal.style.transition = 'opacity 0.3s ease-in-out';
    contentNilai.style.transition = 'opacity 0.3s ease-in-out';

    tabJadwal.onclick = () => {
        setActiveTab(tabJadwal, tabNilai, contentJadwal, contentNilai);
    };

    tabNilai.onclick = () => {
        setActiveTab(tabNilai, tabJadwal, contentNilai, contentJadwal);
    };

    // Add loading animation for cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.group');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

<style>
    /* Additional CSS for better mobile experience */
    @media (max-width: 640px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }
    
    /* Smooth hover transitions */
    .group {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Enhanced shadow on hover */
    .group:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    
    /* Gradient background animation */
    .bg-gradient-to-br {
        background-size: 400% 400%;
        animation: gradientShift 10s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
@endsection