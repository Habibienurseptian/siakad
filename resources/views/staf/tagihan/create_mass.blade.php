@extends('layouts.app')

@section('title', 'Input Massal')

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
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Input Tagihan Massal</h1>
                <p class="text-gray-600">Buat tagihan untuk semua murid di <span class="font-semibold text-green-600">{{ $sekolah->nama }}</span></p>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-6">
                <h2 class="text-xl font-bold text-white">Form Tagihan Massal</h2>
                <p class="text-green-100 text-sm">Isi nominal untuk semua siswa aktif</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('staf.tagihan.input.mass.store', $sekolah->id) }}">
                    @csrf

                    <!-- Pilihan Kelas -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                        <select name="kelas_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Pilih kelas untuk membuat tagihan hanya untuk kelas tersebut. Biarkan kosong untuk semua murid.</p>
                    </div>

                    <!-- Periode -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Periode Tagihan</label>
                        <input type="text" 
                               name="periode" 
                               class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: November 2025" required>
                    </div>

                    <!-- SPP (Total dari SppItem) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total SPP</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="text" 
                                   value="{{ number_format($totalSpp,0,',','.') }}" 
                                   disabled
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-700 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- SPI -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">SPI</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500">Rp</span>
                            <input type="number" 
                                   name="spi" 
                                   value="0" 
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
                                   value="0" 
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
                                   value="0" 
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
                                   value="0" 
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
                                   value="0" 
                                   class="w-full pl-8 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" 
                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200">
                            Simpan Tagihan Massal
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
