@extends('layouts.app')

@section('title', 'Detail Murid')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto border-t-4 border-green-500 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Detail Murid</h1>
            <div class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">Nomor Induk</dt>
                    <dd class="font-medium text-gray-900">{{ $murid->nomor_induk ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Nama</dt>
                    <dd class="font-medium text-gray-900">{{ $murid->user ? $murid->user->name : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Email</dt>
                    <dd class="font-medium text-gray-900">{{ $murid->user ? $murid->user->email : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Kelas</dt>
                    <dd class="font-medium text-gray-900">{{ $murid->kelas ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Sekolah</dt>
                    <dd class="font-medium text-gray-900">{{ $murid->sekolah ? $murid->sekolah->nama : '-' }}</dd>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 p-4 text-center">
            <a href="{{ route('admin.murid.edit', $murid->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.murid.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 transition">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection