@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Schools List -->
        <div class="space-y-8">
            @foreach($sekolahs as $sekolah)
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-1000 group-hover:duration-200"></div>
                
                <div class="relative bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">{{ $sekolah->nama }}</h2>
                                    <p class="text-green-100 text-sm mt-1">Jadwal mata pelajaran semua kelas</p>
                                </div>
                            </div>
                            <button onclick="document.getElementById('modalTambahJadwal').classList.remove('hidden'); 
                                           document.querySelector('#modalTambahJadwal input[name=sekolah_id]').value = '{{ $sekolah->id }}';"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg backdrop-blur-sm transition-all duration-200 hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Jadwal
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        @forelse($sekolah->jadwalByKelas as $kelas => $jadwalByHari)
                        <div class="mb-8 last:mb-0">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Kelas {{ strtoupper($kelas) }}</h3>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    {{ count($jadwalByHari) }} Hari
                                </span>
                            </div>

                            <div class="space-y-6">
                                @foreach($jadwalByHari as $hari => $jadwalsHari)
                                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-white">{{ ucfirst($hari) }}</h4>
                                                <p class="text-emerald-100 text-sm">{{ count($jadwalsHari) }} Mata Pelajaran</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu</th>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mata Pelajaran</th>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Guru</th>
                                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-100">
                                                @foreach($jadwalsHari as $item)
                                                <tr class="hover:bg-green-50 transition-colors duration-150">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                                    </td>
                                                    <td class="px-6 py-4">{{ strtoupper($item->mapel) }}</td>
                                                    <td class="px-6 py-4">{{ $item->guru }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center gap-2">
                                                            <button onclick='openEditModal({{ json_encode($item) }})'
                                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-700 transition-colors" 
                                                                    title="Edit">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                            </button>

                                                            <form id="delete-form-{{ $item->id }}" 
                                                                  action="{{ route('staf.jadwal.destroy', $item->id) }}" 
                                                                  method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                        onclick="confirmDelete({{ $item->id }})"
                                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 transition-colors"
                                                                        title="Hapus">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-16 text-gray-500">Belum ada jadwal</div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@include('staf.jadwal.create', ['gurus' => $gurus])
@include('staf.jadwal.edit', ['gurus' => $gurus])

<!-- ✅ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data pengumuman ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

@endsection
