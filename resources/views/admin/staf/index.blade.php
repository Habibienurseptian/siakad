@extends('layouts.app')

@section('title', 'Data Staf')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- School Cards -->
        <div>
            @foreach($sekolahs as $sekolah)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden mb-6">

                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 sm:px-6 py-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2">
                                    <i class="fa-solid fa-school text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg sm:text-xl font-bold text-white">{{ $sekolah->nama }}</h2>
                                    <p class="text-green-100 text-sm">{{ $stafs[$sekolah->id]->total() }} Staf Terdaftar</p>
                                </div>
                            </div>
                            <button 
                                onclick="document.getElementById('modalStaf-{{ $sekolah->id }}').classList.remove('hidden')" 
                                class="bg-white text-green-600 hover:bg-green-50 font-semibold px-4 sm:px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 justify-center text-sm sm:text-base">
                                <i class="fa-solid fa-plus"></i>
                                <span>Tambah Staf</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 sm:p-6">
                        @php $stafCount = ($stafs[$sekolah->id]->currentPage() - 1) * $stafs[$sekolah->id]->perPage(); @endphp
                        
                        @if($stafs[$sekolah->id]->count() > 0)
                            <div>
                                @foreach($stafs[$sekolah->id] as $staf)
                                    @php $stafCount++; @endphp
                                    
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-3 sm:p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 sm:h-12 sm:w-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-md">
                                                    <span class="text-white text-base sm:text-lg font-bold">{{ strtoupper(substr($staf->user->name ?? '-', 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2 mb-1">
                                                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ $staf->user->name ?? '-' }}</h3>
                                                    <span class="inline-flex items-center justify-center min-w-[24px] h-6 bg-green-100 text-green-700 rounded-full text-xs font-semibold px-2 flex-shrink-0">{{ $stafCount }}</span>
                                                </div>
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 sm:gap-2">
                                                    <div class="text-xs sm:text-sm text-gray-600">
                                                        <i class="fa-solid fa-id-card w-4 text-gray-400"></i>
                                                        <span class="font-medium ml-1">{{ $staf->nip }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <i class="fa-solid fa-briefcase text-gray-400 text-xs sm:text-sm"></i>
                                                        <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $staf->bidang ?? '-' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center gap-2 pt-3 border-t border-gray-200">
                                            <a href="{{ route('admin.staf.show', $staf->id) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs sm:text-sm font-medium">
                                                <i class="fa-solid fa-eye"></i>
                                                <span class="hidden xs:inline">Detail</span>
                                            </a>
                                            <button
                                                onclick="document.getElementById('modalEditStaf-{{ $staf->id }}').classList.remove('hidden')" 
                                                class="flex-1 inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-xs sm:text-sm font-medium">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span class="hidden xs:inline">Edit</span>
                                            </button>
                                            <form action="{{ route('admin.staf.destroy', $staf->id) }}" method="POST" class="form-delete flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="w-full inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs sm:text-sm font-medium">
                                                    <i class="fa-solid fa-trash"></i>
                                                    <span class="hidden xs:inline">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    @include('admin.staf.edit', ['staf' => $staf, 'sekolahs' => $sekolahs])
                                @endforeach
                            </div>

                            <div class="mt-6 flex justify-center">
                                {!! $stafs[$sekolah->id]->links('vendor.pagination.custom') !!}
                            </div>
                        @else
                            <div class="text-center py-8 sm:py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-green-100 to-green-100 rounded-full mb-4">
                                    <i class="fa-solid fa-users-gear text-green-500 text-2xl sm:text-3xl"></i>
                                </div>
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-1">Belum Ada Data Staf</h3>
                                <p class="text-sm sm:text-base text-gray-500 mb-4 sm:mb-6">Mulai tambahkan data staf untuk sekolah ini</p>
                                <button 
                                    onclick="document.getElementById('modalStaf-{{ $sekolah->id }}').classList.remove('hidden')" 
                                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 sm:px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-sm sm:text-base">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Tambah Staf Pertama</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                @include('admin.staf.modal', ['sekolah' => $sekolah])
            @endforeach
        </div>
    </div>
</div>

<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus data staf ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.3s ease-out; }
@media (min-width: 375px) {
    .xs\:inline { display: inline; }
}
</style>

@endsection
