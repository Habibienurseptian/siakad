@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- School Cards -->
        <div>
            @foreach($sekolahs as $sekolah)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden mb-6">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-2">
                                    <i class="fa-solid fa-school text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-white">{{ $sekolah->nama }}</h2>
                                    <p class="text-green-100 text-sm">{{ $gurus[$sekolah->id]->total() }} Guru Terdaftar</p>
                                </div>
                            </div>
                            <button 
                                onclick="document.getElementById('modalGuru-{{ $sekolah->id }}').classList.remove('hidden')" 
                                class="bg-white text-green-600 hover:bg-green-50 font-semibold px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 justify-center">
                                <i class="fa-solid fa-plus"></i>
                                <span>Tambah Guru</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Search Form and Bulk Actions -->
                        <div class="mb-4 flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
                            <form id="search-form-{{ $sekolah->id }}" action="{{ route('admin.guru.index') }}" method="GET" class="flex items-center gap-2 per-school-search-form flex-1" data-sekolah-id="{{ $sekolah->id }}">
                                <input 
                                    id="search-input-{{ $sekolah->id }}"
                                    data-sekolah-id="{{ $sekolah->id }}"
                                    type="text" 
                                    name="search[{{ $sekolah->id }}]" 
                                    value="{{ $search[$sekolah->id] ?? (request('search')[$sekolah->id] ?? '') }}" 
                                    placeholder="Cari guru di {{ $sekolah->nama }}..." 
                                    class="per-school-search-input w-full sm:w-auto flex-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:outline-none">
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all" aria-label="Cari">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </form>

                            <!-- Bulk Actions Button -->
                            <div id="bulk-actions-{{ $sekolah->id }}" class="hidden">
                                <button 
                                    onclick="bulkDelete({{ $sekolah->id }})" 
                                    class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Hapus Terpilih (<span id="count-{{ $sekolah->id }}">0</span>)</span>
                                </button>
                            </div>
                        </div>
                        
                        @php $guruCount = ($gurus[$sekolah->id]->currentPage() - 1) * $gurus[$sekolah->id]->perPage(); @endphp
                        
                        @if($gurus[$sekolah->id]->count() > 0)
                            <!-- Bulk Delete Form -->
                            <form id="bulk-delete-form-{{ $sekolah->id }}" action="{{ route('admin.guru.bulk-delete') }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="ids" id="bulk-ids-{{ $sekolah->id }}">
                            </form>

                            <!-- Desktop Table View -->
                            <div class="hidden lg:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-6 py-3 text-left">
                                                <input 
                                                    type="checkbox" 
                                                    id="select-all-{{ $sekolah->id }}" 
                                                    class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500"
                                                    onchange="toggleAll({{ $sekolah->id }}, this.checked)">
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIP</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Guru</th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($gurus[$sekolah->id] as $guru)
                                            @php $guruCount++; @endphp
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input 
                                                        type="checkbox" 
                                                        class="guru-checkbox-{{ $sekolah->id }} w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500"
                                                        value="{{ $guru->id }}"
                                                        onchange="updateBulkActions({{ $sekolah->id }})">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $guruCount }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-medium text-gray-900">{{ $guru->nip }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                                                            <img src="{{ $guru->profile_image ? asset('storage/' . $guru->profile_image) : asset('images/user.png') }}" 
                                                                 alt="Profile" 
                                                                 class="w-full h-full object-cover">
                                                        </div>
                                                        <span class="text-sm text-gray-900">{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <a href="{{ route('admin.guru.show', $guru->id) }}" 
                                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors duration-200" 
                                                           title="Detail">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                                                           class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-amber-600 hover:bg-amber-50 transition-colors duration-200" 
                                                           title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" 
                                                              method="POST"                                                               
                                                              class="form-delete inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-red-600 hover:bg-red-50 transition-colors duration-200" 
                                                                    title="Hapus">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile & Tablet Card View -->
                            <div class="lg:hidden space-y-4">
                                @php $guruCount = ($gurus[$sekolah->id]->currentPage() - 1) * $gurus[$sekolah->id]->perPage(); @endphp
                                @foreach($gurus[$sekolah->id] as $guru)
                                    @php $guruCount++; @endphp
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="flex-shrink-0 pt-1">
                                                <input 
                                                    type="checkbox" 
                                                    class="guru-checkbox-{{ $sekolah->id }} w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500"
                                                    value="{{ $guru->id }}"
                                                    onchange="updateBulkActions({{ $sekolah->id }})">
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-200">
                                                    <img src="{{ $guru->profile_image ? asset('storage/' . $guru->profile_image) : asset('images/user.png') }}" 
                                                         alt="Profile" 
                                                         class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between gap-2 mb-1">
                                                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}</h3>
                                                    <span class="inline-flex items-center justify-center min-w-[24px] h-6 bg-green-100 text-green-700 rounded-full text-xs font-semibold px-2">{{ $guruCount }}</span>
                                                </div>
                                                <div class="space-y-1">
                                                    <p class="text-sm text-gray-600">
                                                        <i class="fa-solid fa-id-card w-4 text-gray-400"></i>
                                                        <span class="font-medium ml-1">{{ $guru->nip }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 pt-3 border-t border-gray-200">
                                            <a href="{{ route('admin.guru.show', $guru->id) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors text-sm font-medium">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-sm font-medium">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" 
                                                  method="POST" 
                                                  class="form-delete inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6 flex justify-center">
                                {{ $gurus[$sekolah->id]->links('vendor.pagination.custom') }}
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-green-100 to-green-100 rounded-full mb-4">
                                    <i class="fa-solid fa-chalkboard-user text-green-500 text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Data Guru</h3>
                                <p class="text-gray-500 mb-6">Mulai tambahkan data guru untuk sekolah ini</p>
                                <button 
                                    onclick="document.getElementById('modalGuru-{{ $sekolah->id }}').classList.remove('hidden')" 
                                    class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Tambah Guru Pertama</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                @include('admin.guru.modal', ['sekolah' => $sekolah])
            @endforeach
        </div>

    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleAll(sekolahId, checked) {
        const checkboxes = document.querySelectorAll('.guru-checkbox-' + sekolahId);
        checkboxes.forEach(cb => cb.checked = checked);
        updateBulkActions(sekolahId);
    }

    function updateBulkActions(sekolahId) {
        const checkedBoxes = Array.from(document.querySelectorAll('.guru-checkbox-' + sekolahId + ':checked'));
        const uniqueIds = [...new Set(checkedBoxes.map(cb => cb.value))];

        const bulkActions = document.getElementById('bulk-actions-' + sekolahId);
        const count = document.getElementById('count-' + sekolahId);
        const selectAll = document.getElementById('select-all-' + sekolahId);

        if (uniqueIds.length > 0) {
            bulkActions.classList.remove('hidden');
            count.textContent = uniqueIds.length;
        } else {
            bulkActions.classList.add('hidden');
        }

        const allBoxes = Array.from(document.querySelectorAll('.guru-checkbox-' + sekolahId));
        const allUniqueIds = [...new Set(allBoxes.map(cb => cb.value))];
        if (selectAll) {
            selectAll.checked = uniqueIds.length === allUniqueIds.length && allUniqueIds.length > 0;
        }
    }

    function bulkDelete(sekolahId) {
        const checkedBoxes = Array.from(document.querySelectorAll('.guru-checkbox-' + sekolahId + ':checked'));
        const uniqueIds = [...new Set(checkedBoxes.map(cb => cb.value))];

        if (uniqueIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada guru yang dipilih!',
                text: 'Pilih minimal satu guru untuk dihapus.',
                confirmButtonColor: '#16a34a'
            });
            return;
        }

        Swal.fire({
            title: `Hapus ${uniqueIds.length} guru terpilih?`,
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bulk-ids-' + sekolahId).value = uniqueIds.join(',');
                document.getElementById('bulk-delete-form-' + sekolahId).submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus data guru ini?',
                    text: 'Tindakan ini tidak dapat dibatalkan.',
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

    (function(){
        function submitFormIfEmpty(input) {
            var form = document.getElementById('search-form-' + input.dataset.sekolahId);
            if (!form) return;
            input.addEventListener('input', function(e){
                var val = e.target.value.trim();
                if (val === '') form.submit();
            });
        }

        document.querySelectorAll('.per-school-search-input').forEach(function(input){
            submitFormIfEmpty(input);
        });
    })();
</script>

@endsection