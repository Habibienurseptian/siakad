@extends('layouts.app')

@section('title', 'Input Tagihan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex items-center">
            <a href="{{ route('staf.tagihan.index') }}" 
               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md hover:shadow-lg text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-105 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Input Tagihan Siswa</h1>
        </div>

        <!-- Info Murid -->
        <div class="bg-white shadow-lg rounded-xl mb-8 border border-green-100">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 text-white rounded-t-xl flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold">{{ $murid->user->name ?? '-' }}</h2>
                    <p class="text-green-100 text-sm">NIS: {{ $murid->nomor_induk ?? '-' }} • Kelas {{ strtoupper($murid->kelas->nama_kelas ?? '-') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-green-100 text-sm">Sekolah</p>
                    <p class="font-semibold">{{ $murid->sekolah->nama ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg border border-green-100 p-8">
            <form method="POST" action="{{ route('staf.tagihan.input.store', $murid->id) }}">
                @csrf

                <!-- Periode -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                    <input type="text" name="periode"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Contoh: Agustus 2025" required>
                </div>

                <!-- SPP Otomatis -->
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 text-green-800">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">SPP Otomatis</p>
                            <p class="text-sm text-green-700">Nominal dihitung dari seluruh komponen SPP murid ini.</p>
                        </div>
                    </div>
                    @if($sppItems->count())
                    <div class="border-t border-green-200 pt-3">
                        <p class="text-sm text-gray-700">Total Nominal SPP: 
                            <span class="font-semibold text-green-700">{{ number_format($sppItems->sum('jumlah_default'), 0, ',', '.') }}</span>
                        </p>
                    </div>
                    @endif
                </div>


                <!-- SPI -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">SPI (Rp)</label>
                    <input type="number" name="spi"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nominal SPI">
                </div>

                <!-- Kegiatan -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kegiatan (Rp)</label>
                    <input type="number" name="tagihan_kegiatan"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nominal kegiatan">
                </div>

                <!-- Semester Ganjil -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester Ganjil (Rp)</label>
                    <input type="number" name="tagihan_semester_ganjil"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nominal semester ganjil">
                </div>

                <!-- Semester Genap -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semester Genap (Rp)</label>
                    <input type="number" name="tagihan_semester_genap"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nominal semester genap">
                </div>

                <!-- Haul -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Haul / Maulid (Rp)</label>
                    <input type="number" name="haul"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan nominal haul / maulid">
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200 gap-4">
                    <a href="{{ route('staf.tagihan.index') }}"
                       class="px-6 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105">
                        Simpan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
