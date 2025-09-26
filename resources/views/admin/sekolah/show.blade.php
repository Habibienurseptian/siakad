@extends('layouts.app')

@section('title', 'Detail Sekolah')

@section('content')
<div class="container mx-auto max-w-4xl px-4 py-8">
    <div class="bg-green-50 border-l-4 border-r-4 border-green-500 rounded-xl shadow p-8 mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Sekolah</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="font-semibold text-gray-700">Nama Sekolah:</div>
                <div class="mb-2">{{ $sekolah->nama }}</div>
                <div class="font-semibold text-gray-700">Alamat:</div>
                <div class="mb-2">{{ $sekolah->alamat }}</div>
            </div>
            <div>
                <div class="font-semibold text-gray-700">Kepala Sekolah:</div>
                <div class="mb-2">{{ $sekolah->kepala_sekolah }}</div>
                <div class="font-semibold text-gray-700">NPSN:</div>
                <div class="mb-2">{{ $sekolah->npsn }}</div>
            </div>
        </div>
    </div>
    <div class="border-l-4 border-r-4 border-green-500 rounded-xl shadow p-8 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Guru</h2>
        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-gray-50 text-center">
                <tr>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">No</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">NIP</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nama</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sekolah->gurus as $guru)
                <tr class="border-b text-center">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $guru->nip }}</td>
                    <td class="px-4 py-2">{{ $guru->user ? $guru->user->name : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data guru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-l-4 border-r-4 border-green-500 rounded-xl shadow p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Murid</h2>
        <table class="min-w-full divide-y divide-gray-200 mb-4">
            <thead class="bg-gray-50 text-center">
                <tr>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">No</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nomor Induk</th>
                    <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nama</th>
                </tr>
            </thead>
            <tbody>
                @php $muridCount = 0; @endphp
                @foreach($murids as $murid)
                    @if($murid->murid && $murid->murid->sekolah_id == $sekolah->id)
                        @php $muridCount++; @endphp
                        <tr class="border-b text-center">
                            <td class="px-4 py-2">{{ $muridCount }}</td>
                            <td class="px-4 py-2">{{ $murid->murid->nomor_induk ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $murid->name }}</td>
                        </tr>
                    @endif
                @endforeach
                @if($muridCount === 0)
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada data murid.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
