@extends('layouts.app')

@section('title', 'Edit Pengumuman Terbaru')

@section('content')
<div class="container mx-auto max-w-xl px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('staf.pengumuman.index') }}" 
               class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-green-800">
                Edit Pengumuman Terbaru
            </h1>
        </div>
        <form action="{{ route('staf.pengumuman.terbaru.update', $pengumuman_terbaru->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Judul Pengumuman</label>
                <input type="text" name="judul" value="{{ $pengumuman_terbaru->judul }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Isi Pengumuman</label>
                <textarea name="isi" rows="6" class="w-full border rounded px-3 py-2" required>{{ $pengumuman_terbaru->isi }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
