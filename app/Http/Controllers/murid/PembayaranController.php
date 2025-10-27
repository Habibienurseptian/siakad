<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Murid;
use Illuminate\Support\Facades\Http;

class PembayaranController extends Controller
{
    public function index()
    {
        $murid = Murid::where('user_id', auth()->id())->first();
        $tagihanList = collect();
        $belumLunas = collect();
        $totalList = collect();

        if ($murid) {
            $tagihanList = Tagihan::where('murid_id', $murid->id)->get();
            $belumLunas = $tagihanList->where('status', '!=', 'lunas');
            $totalList = $tagihanList->map(function ($tagihan) {
                return (
                    ($tagihan->pembayaran_spp ?? 0) +
                    ($tagihan->uang_saku ?? 0) +
                    ($tagihan->uang_kegiatan ?? 0) +
                    ($tagihan->uang_spi ?? 0) +
                    ($tagihan->uang_haul_maulid ?? 0) +
                    ($tagihan->uang_khidmah_infaq ?? 0) +
                    ($tagihan->uang_zakat ?? 0)
                );
            });
        }

        $grandTotal = $totalList->sum();

        return view('murid.pembayaran.index', compact('tagihanList', 'belumLunas', 'totalList', 'grandTotal'));
    }

    public function ipaymu(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Hitung total tagihan
        $total = (
            ($tagihan->pembayaran_spp ?? 0) +
            ($tagihan->uang_saku ?? 0) +
            ($tagihan->uang_kegiatan ?? 0) +
            ($tagihan->uang_spi ?? 0) +
            ($tagihan->uang_haul_maulid ?? 0) +
            ($tagihan->uang_khidmah_infaq ?? 0) +
            ($tagihan->uang_zakat ?? 0)
        );

        // Ambil kredensial dari .env
        $va = env('IPAYMU_VA');
        $apiKey = env('IPAYMU_API_KEY');
        $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct';

        // Data transaksi
        $body = [
            'name' => auth()->user()->name ?? 'Siswa',
            'phone' => '081234567890',
            'email' => auth()->user()->email ?? 'user@example.com',
            'amount' => $total,
            'referenceId' => (string) $tagihan->id,
            'notifyUrl' => route('murid.pembayaran.notify'),
            'returnUrl' => route('murid.dashboard'),
            'cancelUrl' => route('murid.dashboard'),
            'paymentMethod' => 'qris',
        ];

        // Buat signature
        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp = now()->format('YmdHis');

        try {
            // Kirim request ke iPaymu
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'va' => $va,
                'signature' => $signature,
                'timestamp' => $timestamp,
            ])->post($url, $body);

            // Cek apakah sukses
            if (!$response->ok()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghubungi server iPaymu.',
                    'debug' => $response->body(),
                ]);
            }

            $result = $response->json();

            // Pastikan format response benar
            if (isset($result['Data']['Url'])) {
                return response()->json([
                    'success' => true,
                    'url' => $result['Data']['Url'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['Message'] ?? 'Gagal membuat transaksi iPaymu.',
                    'debug' => $result,
                ]);
            }
        } catch (\Exception $e) {
            // Tangani error jaringan, SSL, dsb
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan koneksi: ' . $e->getMessage(),
            ]);
        }
    }

    public function notify(Request $request)
    {
        $referenceId = $request->input('reference_id');
        $status = strtolower($request->input('status'));

        if (in_array($status, ['berhasil', 'success', 'paid'])) {
            $tagihan = Tagihan::find($referenceId);
            if ($tagihan) {
                $tagihan->update(['status' => 'lunas']);
            }
        }

        return response()->json(['success' => true]);
    }
}
