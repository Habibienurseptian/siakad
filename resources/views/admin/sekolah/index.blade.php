@extends('layouts.app')

@section('title', 'Data Sekolah')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Sekolah</h1>
        <a href="{{ route('admin.sekolah.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200">+ Tambah Sekolah</a>
    </div>

    <!-- Container Grid untuk kartu-kartu -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($sekolahs as $sekolah)
        <!-- Kartu untuk setiap sekolah -->
        <div class="border-t-4 border-green-500 shadow-lg rounded-xl p-4 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-lg text-gray-900 mb-1 truncate">{{ $sekolah->nama }}</h3>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Kepala Sekolah:</span> {{ $sekolah->kepala_sekolah }}
                </p>
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">NPSN:</span> {{ $sekolah->npsn }}
                </p>
            </div>
            <div class="flex-shrink-0 flex justify-end gap-2 mt-4">
                <!-- Tombol Detail -->
                <a href="{{ route('admin.sekolah.show', $sekolah->id) }}" class="p-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-colors duration-200" title="Detail">
                    <i class="fa-solid fa-eye"></i>
                </a>
                <!-- Tombol Edit -->
                <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="p-2 rounded-lg text-yellow-500 hover:bg-yellow-100 transition-colors duration-200" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <!-- Tombol Hapus -->
                <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data sekolah ini?')" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-100 transition-colors duration-200" title="Hapus">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-lg p-6 text-center text-gray-400">
            Belum ada data sekolah.
        </div>
        @endforelse
    </div>
</div>
@endsection
