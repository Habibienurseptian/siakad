@extends('layouts.app')

@section('title', 'Detail Sekolah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Back Button & Header -->
        <div class="mb-6">
            <a href="{{ route('admin.sekolah.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors mb-4">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali ke Daftar Sekolah
            </a>
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fa-solid fa-school text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Sekolah</h1>
                    <p class="text-gray-600 mt-1">Informasi lengkap data sekolah</p>
                </div>
            </div>
        </div>

        <!-- School Information Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="h-2 bg-gradient-to-r from-green-500 to-green-500"></div>
            <div class="p-6 sm:p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fa-solid fa-circle-info text-green-600 mr-3"></i>
                    Informasi Sekolah
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Nama Sekolah -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 border border-green-200 hover:shadow-md transition-shadow">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-building text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-green-700 uppercase mb-2 tracking-wide">Nama Sekolah</p>
                        <p class="text-sm font-bold text-gray-900 leading-snug break-words">{{ $sekolah->nama }}</p>
                    </div>

                    <!-- Kepala Sekolah -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 border border-blue-200 hover:shadow-md transition-shadow">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-user-tie text-blue-600 text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-blue-700 uppercase mb-2 tracking-wide">Kepala Sekolah</p>
                        <p class="text-sm font-bold text-gray-900 leading-snug break-words">{{ $sekolah->kepala_sekolah }}</p>
                    </div>

                    <!-- NPSN -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 border border-purple-200 hover:shadow-md transition-shadow">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-address-card text-purple-600 text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-purple-700 uppercase mb-2 tracking-wide">NPSN</p>
                        <p class="text-sm font-bold text-gray-900 font-mono">{{ $sekolah->npsn }}</p>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-5 border border-amber-200 hover:shadow-md transition-shadow">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-location-dot text-amber-600 text-lg"></i>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-amber-700 uppercase mb-2 tracking-wide">Alamat</p>
                        <p class="text-sm font-bold text-gray-900 leading-snug break-words">{{ $sekolah->alamat }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Kelas Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="h-2 bg-gradient-to-r from-green-500 via-green-500 to-green-500"></div>
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-xl flex items-center justify-center mr-4 shadow-sm">
                            <i class="fa-solid fa-layer-group text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Daftar Kelas</h2>
                            <p class="text-sm text-gray-500">Kelas yang tersedia</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-green-500 text-white rounded-xl text-sm font-bold shadow-md">
                            <i class="fa-solid fa-graduation-cap mr-2"></i>
                            {{ isset($classCount) ? $classCount : 0 }} Kelas
                        </span>
                        <!-- Tombol Tambah Kelas -->
                        <div class="flex justify-end">
                            <button onclick="document.getElementById('modalKelas-{{ $sekolah->id }}').classList.remove('hidden')" 
                                    class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-md transition">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Tambah Kelas
                            </button>
                        </div>

                        @include('admin.sekolah.modal')
                    </div>
                </div>
                
                <div class="overflow-x-auto -mx-6 sm:-mx-8 px-6 sm:px-8">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden rounded-xl border-2 border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-green-50 via-green-50 to-green-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-hashtag mr-2 text-green-500"></i>No
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-door-open mr-2 text-green-500"></i>Nama Kelas
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-chalkboard-teacher mr-2 text-green-500"></i>Wali Kelas
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-users mr-2 text-green-500"></i>Jumlah Siswa
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-green-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-gear mr-2 text-green-500"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($classes as $kelasItem)
                                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-green-50 transition-all duration-200">
                                            <!-- No -->
                                            <td class="px-6 py-4 text-sm text-gray-800 font-semibold">
                                                {{ $loop->iteration }}
                                            </td>

                                            <!-- Nama Kelas -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                                                        <i class="fa-solid fa-chalkboard text-white text-sm"></i>
                                                    </div>
                                                    <span class="text-gray-900 font-bold">{{ strtoupper($kelasItem->nama_kelas) }}</span>
                                                </div>
                                            </td>

                                            <!-- Wali Kelas -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                                                        <i class="fa-solid fa-user text-white text-sm"></i>
                                                    </div>
                                                    <span class="text-gray-900 font-bold">{{ $kelasItem->wali_kelas }}</span>
                                                </div>
                                            </td>

                                            <!-- Jumlah Siswa -->
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                                                        <i class="fa-solid fa-users text-white text-sm"></i>
                                                    </div>
                                                    <span class="text-gray-900 font-bold">{{ $kelasItem->jumlah_siswa }}</span>
                                                </div>
                                            </td>

                                            <!-- Aksi -->
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button 
                                                        onclick="document.getElementById('modalEditKelas-{{ $loop->iteration }}').classList.remove('hidden')" 
                                                        class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg shadow">
                                                        <i class="fa-solid fa-pen mr-1"></i>Edit
                                                    </button>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('admin.sekolah.kelas.destroy', [$sekolah->id, $kelasItem->nama_kelas]) }}" 
                                                          method="POST" 
                                                          class="form-delete inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" 
                                                            class="btn-delete px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg shadow"
                                                            data-nama="{{ $kelasItem->nama_kelas }}">
                                                            <i class="fa-solid fa-trash mr-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Kelas -->
                                        @include('admin.sekolah.modaleditkelas', ['kelasItem' => $kelasItem, 'index' => $loop->iteration])
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-16 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-5 shadow-inner">
                                                        <i class="fa-solid fa-inbox text-gray-400 text-4xl"></i>
                                                    </div>
                                                    <p class="text-gray-700 font-bold text-lg mb-2">Belum Ada Data Kelas</p>
                                                    <p class="text-gray-500 text-sm">Tambahkan kelas untuk memulai pengelolaan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function(e) {
        const form = this.closest('.form-delete');
        const namaKelas = this.dataset.nama;

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            html: `<b>${namaKelas.toUpperCase()}</b> akan dihapus secara permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush