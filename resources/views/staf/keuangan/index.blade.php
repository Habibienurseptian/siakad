@extends('layouts.app')

@section('title', 'Keuangan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Keuangan</h1>
                    <p class="text-gray-600">Kelola keuangan dengan mudah dan efisien</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button onclick="openModal()" 
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Transaksi
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Pemasukan -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-green-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                <div class="relative bg-white border border-green-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            {{ $persenPemasukan > 0 ? '+' : '' }}{{ $persenPemasukan }}%
                        </span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-600 mb-1">Total Pemasukan</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-red-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                <div class="relative bg-white border border-red-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-1 rounded-full">
                            {{ $persenPengeluaran > 0 ? '-' : '' }}{{ $persenPengeluaran }}%
                        </span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-600 mb-1">Total Pengeluaran</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Saldo -->
            <div class="group relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-teal-600 rounded-2xl blur opacity-25 group-hover:opacity-40 transition-opacity"></div>
                <div class="relative bg-white border border-emerald-100 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $persenKas < 0 ? 'text-red-600 bg-red-50' : 'text-emerald-600 bg-emerald-50' }}">
                            {{ $persenKas > 0 ? '+' : ($persenKas < 0 ? '-' : '') }}{{ $persenKas }}%
                        </span>
                    </div>
                    <h3 class="text-sm font-medium text-gray-600 mb-1">Total Keuangan</h3>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($totalKas, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Pemasukan Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Data Pemasukan</h2>
                </div>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <div class="overflow-y-auto max-h-96">
                        <table class="min-w-full">
                        <thead class="bg-gray-100 sticky top-0 z-10" style="position: sticky; top: 0; z-index: 10;">
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Keterangan</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Jumlah</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700 w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pemasukan as $item)
                            <tr class="hover:bg-green-50 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $item->tanggal ?? ($item->updated_at->format('Y-m-d') ?? '-') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="max-w-xs truncate">
                                        <span class="text-gray-900 font-medium">{{ $item->keterangan ?? 'Pembayaran Tagihan' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                        </svg>
                                        Rp {{ number_format(
                                            $item->jumlah ?? (
                                                ($item->pembayaran_spp ?? 0) + 
                                                ($item->uang_saku ?? 0) + 
                                                ($item->uang_kegiatan ?? 0) + 
                                                ($item->uang_spi ?? 0) + 
                                                ($item->uang_haul_maulid ?? 0) + 
                                                ($item->uang_khidmah_infaq ?? 0) + 
                                                ($item->uang_zakat ?? 0)
                                            ), 0, ',', '.'
                                        ) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                         @if(isset($item->id) && isset($item->jenis) && $item->jenis !== null)  
                                            <button type="button" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-700 transition-colors" 
                                                onclick="openEditModal({{ $item->id }}, '{{ $item->tanggal ?? '' }}', '{{ $item->keterangan ?? '' }}', {{ $item->jumlah ?? 0 }}, '{{ $item->jenis ?? '' }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('staf.keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded">Pembayaran Tagihan</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada data pemasukan</p>
                                        <p class="text-gray-400 text-sm mt-1">Tambahkan transaksi pemasukan pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Total Pemasukan -->
                <div class="border-t border-gray-100 mt-6 pt-4">
                    <div class="flex justify-end">
                        <div class="bg-green-50 rounded-lg px-6 py-3">
                            <span class="text-green-800 font-bold text-lg">
                                Total Pemasukan: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Data Pengeluaran</h2>
                </div>
            </div>
            
            <div class="p-6">
                <div class="overflow-x-auto">
                    <div class="overflow-y-auto max-h-96">
                        <table class="min-w-full">
                        <thead class="bg-gray-100 sticky top-0 z-10" style="position: sticky; top: 0; z-index: 10;">
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Keterangan</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700">Jumlah</th>
                                <th class="text-left py-4 px-4 font-semibold text-gray-700 w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($pengeluaran as $item)
                            <tr class="hover:bg-red-50 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $item->tanggal ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="max-w-xs truncate">
                                        <span class="text-gray-900 font-medium">{{ $item->keterangan ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                        </svg>
                                        Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        @if(isset($item->id))
                                            <button type="button" 
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-700 transition-colors" 
                                                onclick="openEditModal({{ $item->id }}, '{{ $item->tanggal ?? '' }}', '{{ $item->keterangan ?? '' }}', {{ $item->jumlah ?? 0 }}, '{{ $item->jenis ?? '' }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <form action="{{ route('staf.keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0016.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada data pengeluaran</p>
                                        <p class="text-gray-400 text-sm mt-1">Tambahkan transaksi pengeluaran pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- Total Pengeluaran -->
                <div class="border-t border-gray-100 mt-6 pt-4">
                    <div class="flex justify-end">
                        <div class="bg-red-50 rounded-lg px-6 py-3">
                            <span class="text-red-800 font-bold text-lg">
                                Total Pengeluaran: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('staf.keuangan.create')

@include('staf.keuangan.edit')

<script>
    function openModal() {
        document.getElementById('keuanganModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('keuanganModal').classList.add('hidden');
    }

    function openEditModal(id, tanggal, keterangan, jumlah, jenis) {
        document.getElementById('editKeuanganModal').classList.remove('hidden');
        document.getElementById('editId').value = id;
        document.getElementById('editTanggal').value = tanggal;
        document.getElementById('editKeterangan').value = keterangan;
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('editJenis').value = jenis;
        document.getElementById('editKeuanganForm').action = '/staf/keuangan/' + id;
    }
    function closeEditModal() {
        document.getElementById('editKeuanganModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-auto-hide');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transform = 'translateY(-100%)';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>

@endsection