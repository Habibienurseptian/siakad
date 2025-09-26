@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-100">
    <div class="container mx-auto max-w-7xl px-3 sm:px-4 py-8 sm:py-12">
        <!-- Header Section -->
            <div class="text-center mb-8 sm:mb-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-green-800 mb-2">
                    <i class="fas fa-credit-card mr-3 text-green-600"></i>
                    Pembayaran
                </h1>
                <p class="text-green-600 text-sm sm:text-base">Pembayaran sekolah dengan mudah dan aman</p>
            </div>
        @php
            $belumLunas = $tagihanList->where('status', '!=', 'lunas');
        @endphp

        {{-- LIST TAGIHAN --}}
        @forelse($belumLunas as $tagihan)
            <div class="bg-yellow-50 shadow-lg rounded-2xl p-6 mb-8 border border-gray-200">
                {{-- HEADER --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Tagihan Bulan {{ $tagihan->periode ?? '-' }}</h3>
                        <p class="text-sm text-gray-500">Detail tagihan untuk periode ini</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-sm font-medium text-gray-600">Status</span>
                        <span class="block mt-1 px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-semibold shadow-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i> Belum Lunas
                        </span>
                    </div>
                </div>

                {{-- TABEL RINCIAN --}}
                <div class="overflow-x-auto rounded-lg bg-gray-50 border border-gray-200">
                    <table class="w-full text-sm sm:text-base">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Deskripsi</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-3">Pembayaran SPP</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->pembayaran_spp, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang Saku</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_saku, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang Kegiatan</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_kegiatan, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang SPI</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_spi, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang Haul/Maulid</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_haul_maulid, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang Khidmah/Infaq</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_khidmah_infaq, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Uang Zakat</td>
                                <td class="px-4 py-3 text-right font-semibold text-green-700">
                                    Rp {{ number_format($tagihan->uang_zakat, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                        @php
                            $subtotal = ($tagihan->pembayaran_spp ?? 0)
                                + ($tagihan->uang_saku ?? 0)
                                + ($tagihan->uang_kegiatan ?? 0)
                                + ($tagihan->uang_spi ?? 0)
                                + ($tagihan->uang_haul_maulid ?? 0)
                                + ($tagihan->uang_khidmah_infaq ?? 0)
                                + ($tagihan->uang_zakat ?? 0);
                        @endphp
                        <tfoot class="bg-green-50">
                            <tr>
                                <td class="px-4 py-4 font-bold text-gray-800">Total</td>
                                <td class="px-4 py-4 text-right md:text-xl font-bold text-green-600">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-2xl shadow-lg">
                <i class="fas fa-receipt text-gray-400 text-4xl"></i>
                <p class="mt-4 text-lg font-medium text-gray-700">Tidak ada tagihan saat ini</p>
                <p class="mt-1 text-sm text-gray-500">Semua tagihan sudah lunas 🎉</p>
            </div>
        @endforelse

        @php
            $grandTotal = $belumLunas->sum(function($tagihan) {
                return ($tagihan->pembayaran_spp ?? 0)
                    + ($tagihan->uang_saku ?? 0)
                    + ($tagihan->uang_kegiatan ?? 0)
                    + ($tagihan->uang_spi ?? 0)
                    + ($tagihan->uang_haul_maulid ?? 0)
                    + ($tagihan->uang_khidmah_infaq ?? 0)
                    + ($tagihan->uang_zakat ?? 0);
            });
        @endphp

        @if($grandTotal > 0)
            <div class="bg-red-100 shadow-lg rounded-2xl p-6 mb-8 border">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Total Tagihan Belum Lunas</h3>
                    <p class="text-2xl font-bold text-red-600 mt-3 sm:mt-0">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endif


        {{-- METODE PEMBAYARAN --}}
        @if($belumLunas->count() > 0)
            <div class="bg-gray-100 shadow-lg rounded-2xl p-6 mt-8 border border-gray-200">
                <h4 class="text-lg font-bold text-gray-800 mb-6">Pilih Metode Pembayaran</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                    <div class="p-5 border rounded-xl shadow-sm hover:shadow-md hover:border-green-400 cursor-pointer transition">
                        <i class="fa-solid fa-money-bill-transfer text-green-600 text-2xl mb-3"></i>
                        <p class="font-semibold text-gray-800">Bank Transfer</p>
                        <p class="text-xs text-gray-500 mt-1">BNI, BRI, Mandiri, BCA</p>
                    </div>
                    <div class="p-5 border rounded-xl shadow-sm hover:shadow-md hover:border-green-400 cursor-pointer transition">
                        <i class="fas fa-wallet text-green-600 text-2xl mb-3"></i>
                        <p class="font-semibold text-gray-800">E-Wallet</p>
                        <p class="text-xs text-gray-500 mt-1">Dana, OVO, Gopay, ShopeePay</p>
                    </div>
                    <div class="p-5 border rounded-xl shadow-sm hover:shadow-md hover:border-green-400 cursor-pointer transition">
                        <i class="fas fa-university text-green-600 text-2xl mb-3"></i>
                        <p class="font-semibold text-gray-800">Virtual Account</p>
                        <p class="text-xs text-gray-500 mt-1">Bayar via kode VA</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
