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
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->pembayaran_spp, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_saku > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Uang Saku</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_saku, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_kegiatan > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Uang Kegiatan</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_kegiatan, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_spi > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">SPI</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_spi, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_haul_maulid > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Haul/Maulid</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_haul_maulid, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_khidmah_infaq > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Khidmah/Infaq</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_khidmah_infaq, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                            @if($tagihan->uang_zakat > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-600">Zakat</span>
                                    <span class="font-medium text-slate-800">
                                        Rp {{ number_format($tagihan->uang_zakat, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-200">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-600 font-medium">Total</span>
                                <span class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
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

                    {{-- Virtual Account (iPaymu) --}}
                    <div class="border-2 border-emerald-200 rounded-lg p-4 hover:border-emerald-400 transition cursor-pointer bg-emerald-50">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-credit-card text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">Pembayaran</p>
                                    <p class="text-xs text-slate-500">Semua Bank</p>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="bayarBtn" data-id="{{ $tagihan->id }}" class="bayar-btn w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition" data-metode="ipaymu">
                            Bayar Sekarang
                        </button>
                    </div>

                    {{-- Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
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
document.getElementById('bayarBtn').addEventListener('click', async function() {
    const tagihanId = this.dataset.id;
    try {
        const response = await fetch(`/murid/pembayaran/${tagihanId}/ipaymu`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({})
        });

        const result = await response.json();

        if(result.success && result.url){
            window.location.href = result.url;
        } else {
            alert(result.message || 'Gagal membuat transaksi iPaymu.');
        }
    } catch(err){
        console.error(err);
        alert('Terjadi kesalahan saat menghubungi server.');
    }
});
</script>


@endsection
