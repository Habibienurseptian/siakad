@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-green-50">
    <div class="container mx-auto max-w-6xl px-4 py-8">

        <div class="grid lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Tagihan List --}}
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-xl font-semibold text-slate-800 mb-4">Tagihan Aktif</h2>
                
                @forelse($belumLunas as $index => $tagihan)
                    @php
                        $subtotal = $totalList[$index] ?? 0;
                    @endphp

                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-slate-800 text-lg">{{ $tagihan->periode ?? '-' }}</h3>
                                <p class="text-sm text-slate-500">Periode pembayaran</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">
                                Belum Lunas
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            @if($tagihan->pembayaran_spp > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">SPP</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->pembayaran_spp, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_saku > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Uang Saku</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_saku, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_kegiatan > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Uang Kegiatan</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_kegiatan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_spi > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">SPI</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_spi, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_haul_maulid > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Haul/Maulid</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_haul_maulid, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_khidmah_infaq > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Khidmah/Infaq</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_khidmah_infaq, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($tagihan->uang_zakat > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-600">Zakat</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($tagihan->uang_zakat, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600 font-medium">Total</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2">Semua Tagihan Lunas</h3>
                        <p class="text-slate-500">Tidak ada tagihan yang perlu dibayar saat ini</p>
                    </div>
                @endforelse
            </div>

            {{-- Right Column: Payment Method --}}
            @if($belumLunas->count() > 0)
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Pembayaran</h2>
                    
                    {{-- Pilih Tagihan --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Tagihan</label>
                        <select id="tagihanSelect" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @foreach($belumLunas as $index => $tagihan)
                                <option value="{{ $tagihan->id }}">{{ $tagihan->periode ?? '-' }} - Rp {{ number_format($totalList[$index] ?? 0, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Metode Pembayaran</label>
                        
                        {{-- Bank Transfer Card --}}
                        <div class="border-2 border-blue-200 rounded-lg p-4 mb-3 hover:border-blue-400 transition cursor-pointer bg-blue-50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building-columns text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">Bank BRI</p>
                                        <p class="text-xs text-slate-500">Transfer Bank</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-3 mb-3">
                                <p class="text-xs text-slate-500 mb-1">Nama Rekening</p>
                                <p class="font-medium text-slate-800 text-sm">Yayasan Pendidikan XYZ</p>
                            </div>
                            <button class="bayar-btn w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition" data-metode="bank" data-bank="BRI">
                                Bayar Sekarang
                            </button>
                        </div>

                        {{-- E-Wallet Card --}}
                        <div class="border-2 border-purple-200 rounded-lg p-4 mb-3 hover:border-purple-400 transition cursor-pointer bg-purple-50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-wallet text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">E-Wallet</p>
                                        <p class="text-xs text-slate-500">Dana, OVO, Gopay</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-3 mb-3">
                                <p class="text-xs text-slate-500 mb-1">Nama Rekening</p>
                                <p class="font-medium text-slate-800 text-sm">Yayasan Pendidikan XYZ</p>
                            </div>
                            <button class="bayar-btn w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition" data-metode="ewallet">
                                Bayar Sekarang
                            </button>
                        </div>

                        {{-- Virtual Account Card --}}
                        <div class="border-2 border-emerald-200 rounded-lg p-4 hover:border-emerald-400 transition cursor-pointer bg-emerald-50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-credit-card text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800">Virtual Account</p>
                                        <p class="text-xs text-slate-500">Semua Bank</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-3 mb-3">
                                <p class="text-xs text-slate-500 mb-1">Nama Rekening</p>
                                <p class="font-medium text-slate-800 text-sm">Yayasan Pendidikan XYZ</p>
                            </div>
                            <button class="bayar-btn w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition" data-metode="va">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                            <div>
                                <p class="text-sm text-blue-900 font-medium mb-1">Informasi</p>
                                <p class="text-xs text-blue-700">Pembayaran akan diverifikasi otomatis dalam 1x24 jam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Grand Total Summary --}}
        @if($grandTotal > 0 && $belumLunas->count() > 0)
        <div class="mt-8 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-white">
                <div>
                    <p class="text-sm opacity-90 mb-1">Total Keseluruhan</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <span class="text-sm font-medium">{{ $belumLunas->count() }} Tagihan Belum Lunas</span>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bayar-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const metode = this.getAttribute('data-metode');
            const tagihanId = document.getElementById('tagihanSelect').value;
            if (!tagihanId) {
                alert('Silakan pilih tagihan yang akan dibayar.');
                return;
            }

            let url = '';
            if (metode === 'bank') {
                url = 'https://sandbox.partner.api.bri.co.id/transfer?tagihan=' + tagihanId;
            } else if (metode === 'ewallet') {
                url = 'https://simulasi-ewallet.com/pay?tagihan=' + tagihanId;
            } else if (metode === 'va') {
                url = 'https://simulasi-va.com/pay?tagihan=' + tagihanId;
            }
            window.open(url, '_blank');

            setTimeout(function() {
                fetch(`/murid/pembayaran/${tagihanId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: 'pending' })
                })
                .then(res => res.json())
                .then(data => {
                    alert('Pembayaran dalam proses. Tunggu konfirmasi.');
                    window.location.reload();
                })
                .catch(() => alert('Terjadi kesalahan saat update status tagihan.'));
            }, 3000);
        });
    });
});
</script>

@endsection