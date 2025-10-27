@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-6 bg-white border-l-4 border-green-500 rounded-lg shadow-sm p-4 flex items-start gap-3 animate-fade-in">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-circle-check text-green-500 text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if($errors->any())
            <div class="mb-6 bg-white border-l-4 border-red-500 rounded-lg shadow-sm p-4 animate-fade-in">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-red-700 text-sm flex items-start gap-2">
                                    <span class="text-red-400">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- School Cards -->
        <div class="space-y-6">
            @foreach($sekolahs as $sekolah)
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                    
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
                        <!-- Search Form for Each School (always visible) -->
                        <div class="mb-4">
                            <form id="search-form-{{ $sekolah->id }}" action="{{ route('admin.guru.index') }}" method="GET" class="flex items-center gap-2 per-school-search-form" data-sekolah-id="{{ $sekolah->id }}">
                                <input 
                                    id="search-input-{{ $sekolah->id }}"
                                    data-sekolah-id="{{ $sekolah->id }}"
                                    type="text" 
                                    name="search[{{ $sekolah->id }}]" 
                                    value="{{ $search[$sekolah->id] ?? (request('search')[$sekolah->id] ?? '') }}" 
                                    placeholder="Cari guru di {{ $sekolah->nama }}..." 
                                    class="per-school-search-input w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-green-200 focus:outline-none">
                                <button 
                                    type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all" aria-label="Cari">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        @php $guruCount = ($gurus[$sekolah->id]->currentPage() - 1) * $gurus[$sekolah->id]->perPage(); @endphp
                        
                        @if($gurus[$sekolah->id]->count() > 0)
                            <!-- Desktop Table View -->
                            <div class="hidden md:block overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr class="bg-gray-50">
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
                                                              onsubmit="return confirm('Yakin ingin menghapus data guru ini?')" 
                                                              class="inline-block">
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

                            <!-- Mobile Card View -->
                            <div class="md:hidden space-y-4">
                                @php $guruCount = ($gurus[$sekolah->id]->currentPage() - 1) * $gurus[$sekolah->id]->perPage(); @endphp
                                @foreach($gurus[$sekolah->id] as $guru)
                                    @php $guruCount++; @endphp
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                                                        <img src="{{ $guru->profile_image ? asset('storage/' . $guru->profile_image) : asset('images/user.png') }}" 
                                                             alt="Profile" 
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                    <span class="text-sm font-semibold text-gray-900">{{ $guru->user ? $guru->user->name : $guru->name ?? '-' }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600">NIP: <span class="font-medium">{{ $guru->nip }}</span></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 pt-3 border-t border-gray-200">
                                            <a href="{{ route('admin.guru.show', $guru->id) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.guru.edit', $guru->id) }}" 
                                               class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-sm font-medium">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('admin.guru.destroy', $guru->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus data guru ini?')" 
                                                  class="flex-1">
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
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                    <i class="fa-solid fa-users text-gray-400 text-2xl"></i>
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

<script>
    // Auto-submit per-school search form when the input is cleared
    (function(){
        document.querySelectorAll('.per-school-search-input').forEach(function(input){
            var form = document.getElementById('search-form-' + input.dataset.sekolahId);
            if (!form) return;
            input.addEventListener('input', function(e){
                var val = e.target.value.trim();
                if (val === '') {
                    form.submit();
                }
            });
        });
    })();
</script>
@endsection