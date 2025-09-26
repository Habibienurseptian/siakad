@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto border-t-4 border-green-500 rounded-lg shadow-md overflow-hidden">
        <!-- Card Header -->
        <div class="p-6">
            <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Detail Guru</h1>
            <p class="text-sm text-gray-500 mb-6 text-center">Informasi lengkap mengenai data guru.</p>

            <!-- Data Grid -->
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm text-gray-500">NIP</dt>
                    <dd class="font-medium text-gray-900">{{ $guru->nip ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                    <dd class="font-medium text-gray-900">{{ $guru->user ? $guru->user->name : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Alamat Email</dt>
                    <dd class="font-medium text-gray-900">{{ $guru->user ? $guru->user->email : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Sekolah</dt>
                    <dd class="font-medium text-gray-900">{{ $guru->sekolah ? $guru->sekolah->nama : '-' }}</dd>
                </div>
            </div>
        </div>
        
        <!-- Action Button -->
        <div class="bg-gray-50 p-4 text-center">
            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.guru.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
