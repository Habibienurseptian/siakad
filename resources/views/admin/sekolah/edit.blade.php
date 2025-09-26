@extends('layouts.app')

@section('title', 'Edit Data Sekolah')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="border-t-4 border-green-500 rounded-xl shadow p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Data Sekolah</h1>
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                <input type="text" name="nama" value="{{ old('nama', $sekolah->nama) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $sekolah->alamat) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                <input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.sekolah.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
