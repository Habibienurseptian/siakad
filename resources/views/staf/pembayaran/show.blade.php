@extends('layouts.app')

@section('title', 'Tagihan Murid')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section with Back Button -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <a href="{{ route('staf.pembayaran.index') }}" 
                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md hover:shadow-lg text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-105 mr-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Detail Tagihan Siswa</h1>
                </div>
            </div>
        </div>

        <!-- Student Information Card -->
        <div class="group relative mb-8">
            <!-- Glow Effect -->
            <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
            
            <!-- Main Student Card -->
            <div class="relative bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Informasi Siswa</h2>
                            <p class="text-green-100 text-sm">Data lengkap siswa dan sekolah</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Nomor Induk</span>
                            </div>
                            <span class="block text-lg font-bold text-gray-900">{{ $murid->nomor_induk }}</span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Nama Siswa</span>
                            </div>
                            <span class="block text-lg font-bold text-gray-900">{{ $murid->user->name ?? '-' }}</span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Sekolah</span>
                            </div>
                            <span class="block text-lg font-bold text-gray-900">{{ $murid->sekolah->nama ?? '-' }}</span>
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Kelas</span>
                            </div>
                            <span class="block text-lg font-bold text-gray-900">{{ strtoupper($murid->kelas->nama_kelas ?? '-') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Billing List Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Daftar Tagihan</h2>
                            <p class="text-emerald-100 text-sm">Riwayat dan status pembayaran</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-white text-sm opacity-90">Total Tagihan</div>
                        <div class="text-white text-lg font-bold">
                            @php
                                $totalTagihan = $murid->tagihans->sum(function($tagihan) {
                                    return $tagihan->pembayaran_spp + $tagihan->uang_saku + $tagihan->uang_kegiatan + 
                                           $tagihan->uang_spi + $tagihan->uang_haul_maulid + $tagihan->uang_khidmah_infaq + $tagihan->uang_zakat;
                                });
                            @endphp
                            Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <span>Jenis Tagihan</span>
                                    </div>
                                </th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span>Total Jumlah</span>
                                    </div>
                                </th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Periode</span>
                                    </div>
                                </th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Status</span>
                                    </div>
                                </th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($murid->tagihans as $tagihan)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <div class="space-y-2">
                                        @php
                                            $tagihanItems = [
                                                ['key' => 'pembayaran_spp', 'label' => 'SPP', 'color' => 'blue'],
                                                ['key' => 'uang_saku', 'label' => 'Uang Saku', 'color' => 'indigo'],
                                                ['key' => 'uang_kegiatan', 'label' => 'Uang Kegiatan', 'color' => 'purple'],
                                                ['key' => 'uang_spi', 'label' => 'Uang SPI', 'color' => 'pink'],
                                                ['key' => 'uang_haul_maulid', 'label' => 'Haul/Maulid', 'color' => 'yellow'],
                                                ['key' => 'uang_khidmah_infaq', 'label' => 'Khidmah/Infaq', 'color' => 'green'],
                                                ['key' => 'uang_zakat', 'label' => 'Zakat', 'color' => 'teal']
                                            ];
                                        @endphp
                                        
                                        @foreach($tagihanItems as $item)
                                            @if($tagihan->{$item['key']})
                                                <div class="flex items-center justify-between p-2 bg-{{ $item['color'] }}-50 rounded-lg">
                                                    <span class="text-sm font-medium text-{{ $item['color'] }}-700">{{ $item['label'] }}</span>
                                                    <span class="text-sm font-bold text-{{ $item['color'] }}-800">
                                                        Rp {{ number_format($tagihan->{$item['key']}, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                        <span class="text-lg font-bold text-green-800">
                                            Rp {{ number_format($tagihan->pembayaran_spp + $tagihan->uang_saku + $tagihan->uang_kegiatan + $tagihan->uang_spi + $tagihan->uang_haul_maulid + $tagihan->uang_khidmah_infaq + $tagihan->uang_zakat, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $tagihan->periode }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if($tagihan->status == 'lunas')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('staf.pembayaran.edit', $tagihan->id) }}" 
                                           class="inline-flex items-center justify-center px-3 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium rounded-lg shadow-sm transition-all duration-200 hover:scale-105">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('staf.pembayaran.destroy', $tagihan->id) }}" method="POST" class="form-delete inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg shadow-sm transition-all duration-200 hover:scale-105">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium mb-2">Belum ada tagihan untuk siswa ini</p>
                                        <p class="text-gray-400 text-sm">Silakan tambahkan tagihan baru untuk memulai</p>
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

<!-- Custom styles for dynamic colors -->
<style>
.bg-blue-50 { background-color: #eff6ff; }
.text-blue-700 { color: #1d4ed8; }
.text-blue-800 { color: #1e40af; }
.bg-indigo-50 { background-color: #eef2ff; }
.text-indigo-700 { color: #4338ca; }
.text-indigo-800 { color: #3730a3; }
.bg-purple-50 { background-color: #faf5ff; }
.text-purple-700 { color: #7c3aed; }
.text-purple-800 { color: #6b21a8; }
.bg-pink-50 { background-color: #fdf2f8; }
.text-pink-700 { color: #be185d; }
.text-pink-800 { color: #9d174d; }
.bg-yellow-50 { background-color: #fefce8; }
.text-yellow-700 { color: #a16207; }
.text-yellow-800 { color: #92400e; }
.bg-teal-50 { background-color: #f0fdfa; }
.text-teal-700 { color: #0f766e; }
.text-teal-800 { color: #115e59; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin menghapus tagihan ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
