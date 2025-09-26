@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="container mx-auto max-w-7xl px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        
        <!-- Pengumuman Terbaru -->
        <div class="border-t-4 border-green-500 rounded-xl shadow p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <h2 class="text-lg md:text-xl font-bold text-green-700">Pengumuman Terbaru</h2>
                <a href="{{ route('staf.pengumuman.terbaru.create') }}" 
                   class="bg-green-600 text-white px-3 md:px-4 py-2 rounded-lg font-semibold text-sm md:text-base">
                    + Tambah
                </a>
            </div>
            @forelse($pengumuman_terbaru as $pengumuman)
                <div class="mb-6 border-b pb-4">
                    <div class="font-semibold text-base md:text-lg break-words">{{ $pengumuman->judul }}</div>
                    <div class="text-gray-700 text-sm md:text-base mb-2">{{ $pengumuman->isi }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ $pengumuman->created_at->translatedFormat('d F Y H:i') }}</div>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <a href="{{ route('staf.pengumuman.terbaru.edit', $pengumuman->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('staf.pengumuman.terbaru.destroy', $pengumuman->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-400 text-sm">Belum ada pengumuman terbaru.</div>
            @endforelse
        </div>

        <!-- Pengumuman Akademik -->
        <div class="border-t-4 border-green-500 rounded-xl shadow p-6 md:p-8">
            <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
                <h2 class="text-lg md:text-xl font-bold text-green-700">Pengumuman Akademik</h2>
                <a href="{{ route('staf.pengumuman.akademik.create') }}" 
                   class="bg-green-600 text-white px-3 md:px-4 py-2 rounded-lg font-semibold text-sm md:text-base">
                    + Tambah
                </a>
            </div>
            @forelse($pengumuman_akademik as $pengumuman)
                <div class="mb-6 border-b pb-4">
                    <div class="font-semibold text-base md:text-lg break-words">{{ $pengumuman->judul }}</div>
                    <div class="text-gray-700 text-sm md:text-base mb-2">{{ $pengumuman->isi }}</div>
                    <div class="text-xs text-gray-400 mb-2">{{ $pengumuman->created_at->translatedFormat('d F Y H:i') }}</div>
                    <div class="flex flex-wrap gap-2 text-sm">
                        <a href="{{ route('staf.pengumuman.akademik.edit', $pengumuman->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('staf.pengumuman.akademik.destroy', $pengumuman->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-400 text-sm">Belum ada pengumuman akademik.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
