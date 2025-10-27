@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 sm:py-8 lg:py-12">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Pengumuman</h1>
            <p class="text-sm sm:text-base text-gray-600">Kelola pengumuman terbaru dan akademik</p>
        </div>

        <!-- Grid Pengumuman -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

            <!-- Pengumuman Terbaru -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 sm:py-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-bullhorn text-white text-lg"></i>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-white">Pengumuman Terbaru</h2>
                        </div>
                        <button 
                            id="openModalTerbaruBtn"
                            class="bg-white text-green-600 hover:bg-green-50 font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                            <i class="fas fa-plus"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </div>

                <!-- Content Card -->
                <div class="p-6 space-y-4 max-h-[600px] overflow-y-auto">
                    @forelse($pengumuman_terbaru as $pengumuman)
                        <div class="group bg-gray-50 hover:bg-white border border-gray-200 hover:border-green-300 rounded-xl p-4 sm:p-5 transition-all duration-200 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="font-semibold text-base sm:text-lg text-gray-800 line-clamp-2 flex-1">
                                    {{ $pengumuman->judul }}
                                </h3>
                                <span class="bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">
                                    Terbaru
                                </span>
                            </div>
                            
                            <p class="text-sm sm:text-base text-gray-600 mb-3 line-clamp-3">
                                {{ $pengumuman->isi }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                                <i class="far fa-clock"></i>
                                <span>{{ $pengumuman->created_at->translatedFormat('d F Y, H:i') }}</span>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button 
                                    type="button"
                                    class="openEditTerbaruBtn flex-1 sm:flex-none bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-medium px-4 py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2"
                                    data-id="{{ $pengumuman->id }}"
                                    data-judul="{{ $pengumuman->judul }}"
                                    data-isi="{{ $pengumuman->isi }}">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('staf.pengumuman.terbaru.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')" class="flex-1 sm:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-medium px-4 py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada pengumuman terbaru</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pengumuman Akademik -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 sm:py-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 p-2 rounded-lg">
                                <i class="fas fa-graduation-cap text-white text-lg"></i>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-white">Pengumuman Akademik</h2>
                        </div>
                        <button 
                            id="openModalAkademikBtn"
                            class="bg-white text-green-600 hover:bg-green-50 font-semibold px-4 py-2.5 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2 text-sm sm:text-base">
                            <i class="fas fa-plus"></i>
                            <span>Tambah</span>
                        </button>
                    </div>
                </div>

                <!-- Content Card -->
                <div class="p-6 space-y-4 max-h-[600px] overflow-y-auto">
                    @forelse($pengumuman_akademik as $pengumuman)
                        <div class="group bg-gray-50 hover:bg-white border border-gray-200 hover:border-green-300 rounded-xl p-4 sm:p-5 transition-all duration-200 hover:shadow-md">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="font-semibold text-base sm:text-lg text-gray-800 line-clamp-2 flex-1">
                                    {{ $pengumuman->judul }}
                                </h3>
                                <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">
                                    Akademik
                                </span>
                            </div>
                            
                            <p class="text-sm sm:text-base text-gray-600 mb-3 line-clamp-3">
                                {{ $pengumuman->isi }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                                <i class="far fa-clock"></i>
                                <span>{{ $pengumuman->created_at->translatedFormat('d F Y, H:i') }}</span>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button 
                                    type="button"
                                    class="openEditAkademikBtn flex-1 sm:flex-none bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-medium px-4 py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2"
                                    data-id="{{ $pengumuman->id }}"
                                    data-judul="{{ $pengumuman->judul }}"
                                    data-isi="{{ $pengumuman->isi }}">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('staf.pengumuman.akademik.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')" class="flex-1 sm:flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-medium px-4 py-2 rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 text-sm">Belum ada pengumuman akademik</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah & Edit -->
@include('staf.pengumuman.create_terbaru')
@include('staf.pengumuman.edit_terbaru')
@include('staf.pengumuman.create_akademik')
@include('staf.pengumuman.edit_akademik')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ======== Pengumuman Terbaru (Tambah) ========
    const modalTerbaru = document.getElementById('modalPengumumanTerbaru');
    const openTerbaruBtn = document.getElementById('openModalTerbaruBtn');
    const closeTerbaruBtn = document.getElementById('closeModalTerbaruBtn');
    const cancelTerbaruBtn = document.getElementById('cancelModalTerbaruBtn');

    if (modalTerbaru && openTerbaruBtn) {
        const openModalTerbaru = () => modalTerbaru.classList.replace('hidden', 'flex');
        const closeModalTerbaru = () => modalTerbaru.classList.replace('flex', 'hidden');
        openTerbaruBtn.addEventListener('click', openModalTerbaru);
        closeTerbaruBtn?.addEventListener('click', closeModalTerbaru);
        cancelTerbaruBtn?.addEventListener('click', closeModalTerbaru);
        modalTerbaru.addEventListener('click', e => { if (e.target === modalTerbaru) closeModalTerbaru(); });
    }

    // ======== Pengumuman Akademik (Tambah) ========
    const modalAkademik = document.getElementById('modalPengumumanAkademik');
    const openAkademikBtn = document.getElementById('openModalAkademikBtn');
    const closeAkademikBtn = document.getElementById('closeModalAkademikBtn');
    const cancelAkademikBtn = document.getElementById('cancelModalAkademikBtn');

    if (modalAkademik && openAkademikBtn) {
        const openModalAkademik = () => modalAkademik.classList.replace('hidden', 'flex');
        const closeModalAkademik = () => modalAkademik.classList.replace('flex', 'hidden');
        openAkademikBtn.addEventListener('click', openModalAkademik);
        closeAkademikBtn?.addEventListener('click', closeModalAkademik);
        cancelAkademikBtn?.addEventListener('click', closeModalAkademik);
        modalAkademik.addEventListener('click', e => { if (e.target === modalAkademik) closeModalAkademik(); });
    }

    // ======== Pengumuman Terbaru (Edit) ========
    const modalEditTerbaru = document.getElementById('modalEditTerbaru');
    const closeEditTerbaruBtn = document.getElementById('closeEditTerbaruBtn');
    const cancelEditTerbaruBtn = document.getElementById('cancelEditTerbaruBtn');

    document.querySelectorAll('.openEditTerbaruBtn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const judul = this.dataset.judul;
            const isi = this.dataset.isi;
            
            document.getElementById('editTerbaruJudul').value = judul;
            document.getElementById('editTerbaruIsi').value = isi;
            document.getElementById('editTerbaruForm').action = `/staf/pengumuman/terbaru/${id}`;

            modalEditTerbaru.classList.replace('hidden', 'flex');
        });
    });

    const closeModalEditTerbaru = () => modalEditTerbaru.classList.replace('flex', 'hidden');
    closeEditTerbaruBtn?.addEventListener('click', closeModalEditTerbaru);
    cancelEditTerbaruBtn?.addEventListener('click', closeModalEditTerbaru);
    modalEditTerbaru?.addEventListener('click', e => { if (e.target === modalEditTerbaru) closeModalEditTerbaru(); });

    // ======== Pengumuman Akademik (Edit) ========
    const modalEditAkademik = document.getElementById('modalEditAkademik');
    const closeEditAkademikBtn = document.getElementById('closeEditAkademikBtn');
    const cancelEditAkademikBtn = document.getElementById('cancelEditAkademikBtn');

    document.querySelectorAll('.openEditAkademikBtn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const judul = this.dataset.judul;
            const isi = this.dataset.isi;

            document.getElementById('editAkademikJudul').value = judul;
            document.getElementById('editAkademikIsi').value = isi;
            document.getElementById('editAkademikForm').action = `/staf/pengumuman/akademik/${id}`;

            modalEditAkademik.classList.replace('hidden', 'flex');
        });
    });

    const closeModalEditAkademik = () => modalEditAkademik.classList.replace('flex', 'hidden');
    closeEditAkademikBtn?.addEventListener('click', closeModalEditAkademik);
    cancelEditAkademikBtn?.addEventListener('click', closeModalEditAkademik);
    modalEditAkademik?.addEventListener('click', e => { if (e.target === modalEditAkademik) closeModalEditAkademik(); });
});
</script>
@endpush