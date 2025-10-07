<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class PembayaranApiController extends Controller
{
    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::find($id);
        if (!$tagihan) {
            return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
        }

        if ($request->status !== 'lunas') {
            return response()->json(['message' => 'Status tidak valid'], 400);
        }

        $tagihan->status = 'lunas';
        $tagihan->save();

        return response()->json([
            'status' => 'lunas',
            'message' => 'Tagihan berhasil dilunasi'
        ]);
    }

}
