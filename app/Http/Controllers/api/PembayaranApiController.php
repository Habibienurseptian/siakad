<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class PembayaranApiController extends Controller
{
    /**
     * Update status pembayaran tagihan menjadi lunas.
     */
    public function update(Request $request, $id)
    {
        // Ambil data tagihan berdasarkan ID
        $tagihan = Tagihan::find($id);

        if (!$tagihan) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak ditemukan.',
            ], 404);
        }

        // Jika status sudah lunas sebelumnya
        if ($tagihan->status === 'lunas') {
            return response()->json([
                'success' => true,
                'message' => 'Tagihan sudah lunas sebelumnya.',
                'data' => [
                    'id' => $tagihan->id,
                    'status' => $tagihan->status,
                    'updated_at' => $tagihan->updated_at->format('Y-m-d H:i:s'),
                ]
            ], 200);
        }

        // Update status tagihan menjadi 'lunas'
        $tagihan->status = 'lunas';
        $tagihan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status tagihan berhasil diperbarui menjadi lunas.',
            'data' => [
                'id' => $tagihan->id,
                'status' => $tagihan->status,
                'updated_at' => $tagihan->updated_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }
}
