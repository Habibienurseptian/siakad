@extends('layouts.app')

@section('title', 'Detail Staf')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto border-t-4 border-green-500 rounded-lg shadow-md overflow-hidden">
        <!-- Card Header -->
        <div class="p-6">
            <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Detail Staf</h1>
            <p class="text-sm text-gray-500 mb-6 text-center">Informasi lengkap mengenai data staf.</p>

            <!-- Data Grid -->
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm text-gray-500">NIP</dt>
                    <dd class="font-medium text-gray-900">{{ $staf->nip ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                    <dd class="font-medium text-gray-900">{{ $staf->user ? $staf->user->name : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Alamat Email</dt>
                    <dd class="font-medium text-gray-900">{{ $staf->user ? $staf->user->email : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Sekolah</dt>
                    <dd class="font-medium text-gray-900">{{ $staf->sekolah ? $staf->sekolah->nama : '-' }}</dd>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="bg-gray-50 p-4 text-center space-x-2">
            <a href="{{ route('admin.staf.edit', $staf->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.staf.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
