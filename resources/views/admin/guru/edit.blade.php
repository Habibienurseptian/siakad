@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<div class="container mx-auto max-w-lg px-4 py-8">
    <div class="border-t-4 border-green-500 rounded-xl shadow p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Guru</h1>
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
        <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ $guru->user ? $guru->user->name : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ $guru->user ? $guru->user->email : '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ $guru->nip }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sekolah</label>
                <select name="sekolah_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Sekolah --</option>
                    @foreach($sekolahs as $sekolah)
                        <option value="{{ $sekolah->id }}" {{ ($guru->sekolah_id == $sekolah->id) ? 'selected' : '' }}>{{ $sekolah->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.guru.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
