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
        $grandTotal = 0;

        if ($murid) {
            $tagihanList = Tagihan::where('murid_id', $murid->id)->get();

            // Hitung subtotal per tagihan
            $tagihanList->each(function ($tagihan) {
                $tagihan->subtotal = 
                    ($tagihan->spp ?? 0) +
                    ($tagihan->tagihan_kegiatan ?? 0) +
                    ($tagihan->spi ?? 0) +
                    ($tagihan->tagihan_semester_ganjil ?? 0) +
                    ($tagihan->tagihan_semester_genap ?? 0) +
                    ($tagihan->haul ?? 0);
            });

            $belumLunas = $tagihanList->where('status', '!=', 'lunas');

            // Grand total hanya dari tagihan yang belum lunas
            $grandTotal = $belumLunas->sum('subtotal');
        }

        return view('murid.pembayaran.index', compact('tagihanList', 'belumLunas', 'grandTotal'));
    }

    public function ipaymu(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Gunakan subtotal dari controller jika sudah tersedia
        $total = $tagihan->subtotal ?? (
            ($tagihan->spp ?? 0) +
            ($tagihan->tagihan_kegiatan ?? 0) +
            ($tagihan->spi ?? 0) +
            ($tagihan->tagihan_semester_ganjil ?? 0) +
            ($tagihan->tagihan_semester_genap ?? 0) +
            ($tagihan->haul ?? 0)
        );

        $va      = env('IPAYMU_VA');
        $apiKey  = env('IPAYMU_API_KEY');
        $url     = 'https://sandbox.ipaymu.com/api/v2/payment';
        $method  = 'POST';

        $body = [
            'product'       => ['Pembayaran Santri #' . $tagihan->id],
            'qty'           => [1],
            'price'         => [$total],
            'returnUrl'     => route('murid.dashboard'),
            'cancelUrl'     => route('murid.dashboard'),
            'notifyUrl'     => route('murid.pembayaran.notify'),
            'referenceId'   => (string) $tagihan->id,
        ];

        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $va . ':' . $requestBody . ':' . $apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $apiKey);
        $timestamp    = date('YmdHis');

        try {
            $response = Http::withHeaders([
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'va'            => $va,
                'signature'     => $signature,
                'timestamp'     => $timestamp,
            ])->withBody($jsonBody, 'application/json')->post($url);

            if (!$response->ok()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal koneksi ke iPaymu.',
                    'debug'   => $response->body(),
                ]);
            }

            $result = $response->json();

            if (isset($result['Status']) && $result['Status'] == 200) {
                $redirectUrl = $result['Data']['Url'] ?? null;

                return response()->json([
                    'success' => true,
                    'url'     => $redirectUrl,
                    'data'    => $result['Data'],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['Message'] ?? 'Gagal membuat transaksi iPaymu.',
                'debug'   => $result,
            ]);
        } catch (\Exception $e) {
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
