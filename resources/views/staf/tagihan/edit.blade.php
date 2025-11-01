@extends('layouts.app')

@section('title', 'Edit Tagihan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex items-center">
            <a href="{{ route('staf.tagihan.index') }}" 
               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md hover:shadow-lg text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-105 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Edit Tagihan</h1>
                <p class="text-gray-600">
                    Perbarui tagihan untuk 
                    <span class="font-semibold text-green-600">{{ $tagihan->murid->user->name ?? '-' }}</span>
                </p>
            </div>
        </div>

        <!-- Card -->
        <div class="relative bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-6">
                <h2 class="text-xl font-bold text-white">Form Edit Tagihan</h2>
                <p class="text-green-100 text-sm">Ubah rincian atau nominal tagihan</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('staf.tagihan.update', $tagihan->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Periode -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <input type="text" 
                               name="periode" 
                               value="{{ $tagihan->periode }}" 
                               class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500" 
                               placeholder="Contoh: 2025-Ganjil">
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                            <option value="belum_lunas" {{ $tagihan->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ $tagihan->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <!-- SPP -->
                    @if($sppItems->count())
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SPP</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                value="{{ number_format($totalSpp, 0, ',', '.') }}" 
                                disabled
                                class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
                            <input type="hidden" name="spp" value="{{ $totalSpp }}">
                        </div>
                    </div>
                    @endif

                    <!-- SPI -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SPI</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="spi" 
                                   value="{{ $tagihan->spi ?? 0 }}" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Kegiatan -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagihan Kegiatan</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="tagihan_kegiatan" 
                                   value="{{ $tagihan->tagihan_kegiatan ?? 0 }}" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Semester Ganjil -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagihan Semester Ganjil</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="tagihan_semester_ganjil" 
                                   value="{{ $tagihan->tagihan_semester_ganjil ?? 0 }}" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Semester Genap -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tagihan Semester Genap</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="tagihan_semester_genap" 
                                   value="{{ $tagihan->tagihan_semester_genap ?? 0 }}" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Haul -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Haul / Maulid</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="haul" 
                                   value="{{ $tagihan->haul ?? 0 }}" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Total Tagihan -->
                    <div class="mb-6 pt-4 border-t border-gray-200">
                        <p class="text-gray-700 font-semibold mb-2">Total Tagihan Saat Ini:</p>
                        <p class="text-2xl font-bold text-green-700">
                            Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ route('staf.tagihan.index') }}" 
                           class="inline-flex items-center px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-150">
                            Batal
                        </a>

                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
