@extends('layouts.app')

@section('title', 'Tambah Data Sekolah')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="bg-white rounded-xl shadow p-8">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Sekolah</h1>
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
        <form action="{{ route('admin.sekolah.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Sekolah</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NPSN</label>
                <input type="text" name="npsn" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
            </div>
            <div class="flex justify-end gap-3 mt-5">
                <a href="{{ route('admin.sekolah.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
