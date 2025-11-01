@extends('layouts.app')

@section('title', 'Rincian Pembayaran SPP')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Rincian Pembayaran SPP</h1>
                <p class="text-gray-600 text-sm mt-1">Atur komponen dan nominal tetap untuk tagihan SPP</p>
            </div>
            <button id="openModalTambahBtn" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Komponen SPP
            </button>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-lg rounded-xl border border-green-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-sm font-semibold">#</th>
                        <th class="py-3 px-6 text-sm font-semibold">Nama Komponen</th>
                        <th class="py-3 px-6 text-sm font-semibold">Nominal (Rp)</th>
                        <th class="py-3 px-6 text-sm font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sppItems as $i => $item)
                        <tr class="border-b hover:bg-green-50">
                            <td class="py-3 px-6 text-gray-700">{{ $i + 1 }}</td>
                            <td class="py-3 px-6 font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="py-3 px-6 text-gray-700">Rp {{ number_format($item->jumlah_default, 0, ',', '.') }}</td>
                            <td class="py-3 px-6 text-right space-x-2">
                                <button 
                                    type="button"
                                    class="openEditBtn text-blue-600 hover:text-blue-800 font-medium"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-jumlah="{{ $item->jumlah_default }}">
                                    Edit
                                </button>
                                <form action="{{ route('staf.spp.destroy', $item->id) }}" method="POST" class="inline deleteForm">
                                    @csrf @method('DELETE')
                                    <button type="button" class="deleteBtn text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500">Belum ada rincian SPP</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sppItems->count())
            <div class="mt-6 text-right">
                <p class="text-gray-700 font-semibold">
                    Total SPP: 
                    <span class="text-green-700">Rp {{ number_format($sppItems->sum('jumlah_default'), 0, ',', '.') }}</span>
                </p>
            </div>
        @endif

    </div>
</div>

<!-- Modal Tambah SPP -->
@include('staf.spp.create')

<!-- Modal Edit SPP -->
@include('staf.spp.edit')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ======== Modal Tambah SPP ========
    const modalTambah = document.getElementById('modalTambahSPP');
    const openTambahBtn = document.getElementById('openModalTambahBtn');
    const closeTambahBtn = document.getElementById('closeModalTambahBtn');
    const cancelTambahBtn = document.getElementById('cancelModalTambahBtn');

    if (modalTambah && openTambahBtn) {
        const openModalTambah = () => modalTambah.classList.replace('hidden', 'flex');
        const closeModalTambah = () => modalTambah.classList.replace('flex', 'hidden');
        openTambahBtn.addEventListener('click', openModalTambah);
        closeTambahBtn?.addEventListener('click', closeModalTambah);
        cancelTambahBtn?.addEventListener('click', closeModalTambah);
        modalTambah.addEventListener('click', e => { if (e.target === modalTambah) closeModalTambah(); });
    }

    // ======== Modal Edit SPP ========
    const modalEdit = document.getElementById('modalEditSPP');
    const closeEditBtn = document.getElementById('closeModalEditBtn');
    const cancelEditBtn = document.getElementById('cancelModalEditBtn');

    document.querySelectorAll('.openEditBtn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const jumlah = this.dataset.jumlah;
            
            document.getElementById('editNama').value = nama;
            document.getElementById('editJumlah').value = jumlah;
            document.getElementById('editSPPForm').action = `/staf/spp/${id}`;

            modalEdit.classList.replace('hidden', 'flex');
        });
    });

    const closeModalEdit = () => modalEdit.classList.replace('flex', 'hidden');
    closeEditBtn?.addEventListener('click', closeModalEdit);
    cancelEditBtn?.addEventListener('click', closeModalEdit);
    modalEdit?.addEventListener('click', e => { if (e.target === modalEdit) closeModalEdit(); });

    // ======== SweetAlert Delete Confirmation ========
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Komponen SPP ini akan dihapus permanen!",
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
        });
    });
});
</script>
@endpush