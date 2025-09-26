<?php
namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengumumanTerbaru;
use App\Models\PengumumanAkademik;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index()
    {
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $pengumuman_terbaru = collect();
        $pengumuman_akademik = collect();
        if ($staf && $staf->sekolah_id) {
            $pengumuman_terbaru = PengumumanTerbaru::where('sekolah_id', $staf->sekolah_id)->orderBy('created_at', 'desc')->get();
            $pengumuman_akademik = PengumumanAkademik::where('sekolah_id', $staf->sekolah_id)->orderBy('created_at', 'desc')->get();
        }
        // Convert ke WIB
        $pengumuman_terbaru->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });
        $pengumuman_akademik->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at)->timezone('Asia/Jakarta');
            return $item;
        });
        return view('staf.pengumuman.index', compact('pengumuman_terbaru', 'pengumuman_akademik'));
    }

    // CRUD Pengumuman Terbaru
    public function createTerbaru() { return view('staf.pengumuman.create_terbaru'); }
    public function storeTerbaru(Request $request) {
        $request->validate(['judul' => 'required', 'isi' => 'required']);
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $data = $request->only(['judul', 'isi']);
        if ($staf && $staf->sekolah_id) {
            $data['sekolah_id'] = $staf->sekolah_id;
        }
        PengumumanTerbaru::create($data);
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman terbaru berhasil ditambahkan.');
    }
    public function editTerbaru($id) {
        $pengumuman_terbaru = PengumumanTerbaru::findOrFail($id);
        return view('staf.pengumuman.edit_terbaru', compact('pengumuman_terbaru'));
    }
    public function updateTerbaru(Request $request, $id) {
        $request->validate(['judul' => 'required', 'isi' => 'required']);
        $pengumuman_terbaru = PengumumanTerbaru::findOrFail($id);
        $pengumuman_terbaru->update($request->only(['judul', 'isi']));
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman terbaru berhasil diupdate.');
    }
    public function destroyTerbaru($id) {
        PengumumanTerbaru::destroy($id);
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman terbaru berhasil dihapus.');
    }

    // CRUD Pengumuman Akademik
    public function createAkademik() { return view('staf.pengumuman.create_akademik'); }
    public function storeAkademik(Request $request) {
        $request->validate(['judul' => 'required', 'isi' => 'required']);
        $staf = \App\Models\Staf::where('user_id', auth()->id())->first();
        $data = $request->only(['judul', 'isi']);
        if ($staf && $staf->sekolah_id) {
            $data['sekolah_id'] = $staf->sekolah_id;
        }
        PengumumanAkademik::create($data);
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman akademik berhasil ditambahkan.');
    }
    public function editAkademik($id) {
        $pengumuman_akademik = PengumumanAkademik::findOrFail($id);
        return view('staf.pengumuman.edit_akademik', compact('pengumuman_akademik'));
    }
    public function updateAkademik(Request $request, $id) {
        $request->validate(['judul' => 'required', 'isi' => 'required']);
        $pengumuman_akademik = PengumumanAkademik::findOrFail($id);
        $pengumuman_akademik->update($request->only(['judul', 'isi']));
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman akademik berhasil diupdate.');
    }
    public function destroyAkademik($id) {
        PengumumanAkademik::destroy($id);
        return redirect()->route('staf.pengumuman.index')->with('success', 'Pengumuman akademik berhasil dihapus.');
    }
}
