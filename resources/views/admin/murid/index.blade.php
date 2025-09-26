@extends('layouts.app')

@section('title', 'Data Murid')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Data Murid</h1>

    <!-- Notifikasi Sukses -->
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

    <div class="flex flex-col gap-8 w-full max-w-6xl mx-auto mt-4 mb-8">
    @foreach($sekolahs as $sekolah)
            <div class="border-t-4 border-green-500 shadow-lg rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-green-700">{{ $sekolah->nama }}</h2>
                    <button 
                        onclick="document.getElementById('modalMurid-{{ $sekolah->id }}').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition-all duration-200">
                        + Tambah Murid
                    </button>
                </div>

                <table class="min-w-full divide-y divide-gray-200 mb-2">
                    <thead class="bg-gray-50 text-center">
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600">No</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nomor Induk</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600">Nama</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600">Kelas</th>
                            <th class="px-4 py-2 text-xs font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $muridCount = 0; @endphp
                        @foreach($murids[$sekolah->id] as $murid)
                            @php $muridCount++; @endphp
                            <tr class="border-b text-center">
                                <td class="px-4 py-2">{{ $muridCount }}</td>
                                <td class="px-4 py-2">{{ $murid->nomor_induk }}</td>
                                <td class="px-4 py-2">{{ $murid->user ? $murid->user->name : '-' }}</td>
                                <td class="px-4 py-2">{{ $murid->kelas }}</td>
                                <td class="px-4 py-2 flex gap-2 justify-center">
                                    <a href="{{ route('admin.murid.show', $murid->id) }}" class="p-2 rounded-lg text-blue-500 hover:bg-blue-100 transition-colors duration-200" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.murid.edit', $murid->id) }}" class="p-2 rounded-lg text-yellow-500 hover:bg-yellow-100 transition-colors duration-200" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.murid.destroy', $murid->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data murid ini?')" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-100 transition-colors duration-200" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if($muridCount === 0)
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data murid.</td>
                            </tr>
                        @endif
                        <!-- Pagination di dalam tabel -->
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center">{!! $murids[$sekolah->id]->links('vendor.pagination.custom') !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @include('admin.murid.modal', ['sekolah' => $sekolah])
        @endforeach
    </div>
</div>
@endsection
