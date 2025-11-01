@extends('layouts.app')

@section('title', 'Detail Tagihan Siswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-50 py-6">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex items-center">
            <a href="{{ route('staf.tagihan.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md hover:shadow-lg text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-105 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Tagihan Siswa</h1>
                <p class="text-gray-500 text-sm">Lihat rincian dan status pembayaran</p>
            </div>
        </div>

        <!-- Informasi Murid -->
        <div class="bg-white rounded-2xl shadow-lg border border-green-100 overflow-hidden mb-10">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 text-white font-semibold">Informasi Siswa</div>
            <div class="p-6 grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Nomor Induk</p>
                    <p class="font-semibold text-gray-900">{{ $murid->nomor_induk ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-semibold text-gray-900">{{ $murid->user->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sekolah</p>
                    <p class="font-semibold text-gray-900">{{ $murid->sekolah->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-semibold text-gray-900">{{ strtoupper($murid->kelas->nama_kelas ?? '-') }}</p>
                </div>
            </div>
        </div>

        <!-- Daftar Tagihan -->
        @forelse ($murid->tagihans as $tagihan)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 mb-6">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-white">Tagihan Periode: {{ $tagihan->periode ?? '-' }}</h2>
                </div>
                <div class="text-right">
                    @if($tagihan->status === 'lunas')
                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-semibold inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Lunas
                        </span>
                    @else
                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-semibold inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Belum Lunas
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-4">

                <!-- SPP -->
                @if($sppItems->count())
                <div class="border border-blue-200 rounded-xl p-4 bg-blue-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white mb-2">SPP</span>
                        <h3 class="font-semibold text-gray-900">Sumbangan Pembinaan Pendidikan</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-blue-700">
                        Rp {{ number_format($tagihan->totalSpp, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- SPI -->
                @if($tagihan->spi > 0)
                <div class="border border-purple-200 rounded-xl p-4 bg-purple-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-purple-600 text-white mb-2">SPI</span>
                        <h3 class="font-semibold text-gray-900">Sumbangan Pembangunan</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-purple-700">
                        Rp {{ number_format($tagihan->spi, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- Kegiatan -->
                @if($tagihan->tagihan_kegiatan > 0)
                <div class="border border-teal-200 rounded-xl p-4 bg-teal-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-teal-600 text-white mb-2">KEGIATAN</span>
                        <h3 class="font-semibold text-gray-900">Tagihan Kegiatan</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-teal-700">
                        Rp {{ number_format($tagihan->tagihan_kegiatan, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- Semester Ganjil -->
                @if($tagihan->tagihan_semester_ganjil > 0)
                <div class="border border-orange-200 rounded-xl p-4 bg-orange-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-orange-600 text-white mb-2">SEMESTER GANJIL</span>
                        <h3 class="font-semibold text-gray-900">Tagihan Semester Ganjil</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-orange-700">
                        Rp {{ number_format($tagihan->tagihan_semester_ganjil, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- Semester Genap -->
                @if($tagihan->tagihan_semester_genap > 0)
                <div class="border border-amber-200 rounded-xl p-4 bg-amber-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-amber-600 text-white mb-2">SEMESTER GENAP</span>
                        <h3 class="font-semibold text-gray-900">Tagihan Semester Genap</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-amber-700">
                        Rp {{ number_format($tagihan->tagihan_semester_genap, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- Haul -->
                @if($tagihan->haul > 0)
                <div class="border border-pink-200 rounded-xl p-4 bg-pink-50 flex justify-between items-center">
                    <div>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-pink-600 text-white mb-2">HAUL</span>
                        <h3 class="font-semibold text-gray-900">Haul / Maulid</h3>
                    </div>
                    <div class="text-right text-xl font-bold text-pink-700">
                        Rp {{ number_format($tagihan->haul, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                <!-- Total Tagihan -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Total Tagihan Periode Ini</p>
                        <p class="text-2xl font-bold text-green-700">
                            Rp {{ number_format($tagihan->totalTagihan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('staf.tagihan.edit', $tagihan->id) }}"
                           class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm rounded-lg font-medium flex items-center gap-2 transition">
                            Edit Tagihan
                        </a>
                        <form action="{{ route('staf.tagihan.destroy', $tagihan->id) }}" method="POST" class="inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg font-medium flex items-center gap-2 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
            <p class="text-gray-500 font-semibold text-lg">Belum ada tagihan</p>
            
        </div>
        @endforelse

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data tagihan ini akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
});
</script>
@endsection
