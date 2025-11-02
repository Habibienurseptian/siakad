@extends('layouts.app')

@section('title', 'Data Sekolah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Data Sekolah
                    </h1>
                    <p class="text-gray-600 mt-1">Data sekolah yang terdaftar</p>
                </div>
                <button id="openModalTambahBtn"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-semibold rounded-lg shadow-lg hover:from-green-700 hover:to-green-700 hover:shadow-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Sekolah
                </button>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($sekolahs as $sekolah)
            <!-- School Card -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                <div class="h-2 bg-gradient-to-r from-green-500 to-green-500"></div>
                
                <div class="p-6">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-2 group-hover:text-green-600 transition-colors">
                                {{ $sekolah->nama }}
                            </h3>
                        </div>
                    </div>

                    <div class="space-y-3 mb-5">
                        <div class="flex items-start">
                            <i class="fa-solid fa-address-card w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0"></i>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 font-medium">Kepala Sekolah</p>
                                <p class="text-sm text-gray-800 font-semibold truncate">{{ $sekolah->kepala_sekolah }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <i class="fa-solid fa-school w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0"></i>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 font-medium">NPSN</p>
                                <p class="text-sm text-gray-800 font-mono font-semibold">{{ $sekolah->npsn }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.sekolah.show', $sekolah->id) }}" 
                            class="flex-1 flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200"
                            title="Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        <button 
                            type="button"
                            class="openEditBtn flex-1 flex items-center justify-center px-3 py-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors duration-200"
                            data-id="{{ $sekolah->id }}"
                            data-nama="{{ $sekolah->nama }}"
                            data-alamat="{{ $sekolah->alamat }}"
                            data-kepala="{{ $sekolah->kepala_sekolah }}"
                            data-npsn="{{ $sekolah->npsn }}"
                            title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>

                        <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" class="flex-1 delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                class="w-full flex items-center justify-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200 delete-btn"
                                title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data Sekolah</h3>
                    <p class="text-gray-500 mb-6">Mulai tambahkan data sekolah untuk mengelola informasi sekolah</p>
                    <button id="openModalTambahBtnEmpty"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-600 text-white font-semibold rounded-lg shadow-lg hover:from-green-700 hover:to-green-700 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Sekolah Pertama
                    </button>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Tambah Sekolah -->
@include('admin.sekolah.create')

<!-- Modal Edit Sekolah -->
@include('admin.sekolah.edit')

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ======== Modal Tambah Sekolah ========
    const modalTambah = document.getElementById('modalTambahSekolah');
    const openTambahBtn = document.getElementById('openModalTambahBtn');
    const openTambahBtnEmpty = document.getElementById('openModalTambahBtnEmpty');
    const closeTambahBtn = document.getElementById('closeModalTambahBtn');
    const cancelTambahBtn = document.getElementById('cancelModalTambahBtn');

    const openModalTambah = () => modalTambah.classList.replace('hidden', 'flex');
    const closeModalTambah = () => modalTambah.classList.replace('flex', 'hidden');
    
    if (modalTambah) {
        openTambahBtn?.addEventListener('click', openModalTambah);
        openTambahBtnEmpty?.addEventListener('click', openModalTambah);
        closeTambahBtn?.addEventListener('click', closeModalTambah);
        cancelTambahBtn?.addEventListener('click', closeModalTambah);
        modalTambah.addEventListener('click', e => { if (e.target === modalTambah) closeModalTambah(); });
    }

    // ======== Modal Edit Sekolah ========
    const modalEdit = document.getElementById('modalEditSekolah');
    const closeEditBtn = document.getElementById('closeModalEditBtn');
    const cancelEditBtn = document.getElementById('cancelModalEditBtn');

    document.querySelectorAll('.openEditBtn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const alamat = this.dataset.alamat;
            const kepala = this.dataset.kepala;
            const npsn = this.dataset.npsn;
            
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editKepala').value = kepala;
            document.getElementById('editNpsn').value = npsn;
            document.getElementById('editSekolahForm').action = `/admin/sekolah/${id}`;

            modalEdit.classList.replace('hidden', 'flex');
        });
    });

    const closeModalEdit = () => modalEdit.classList.replace('flex', 'hidden');
    closeEditBtn?.addEventListener('click', closeModalEdit);
    cancelEditBtn?.addEventListener('click', closeModalEdit);
    modalEdit?.addEventListener('click', e => { if (e.target === modalEdit) closeModalEdit(); });

    // ======== SweetAlert Delete Confirmation ========
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            const form = this.closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data sekolah ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush