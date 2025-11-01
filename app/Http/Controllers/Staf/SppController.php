<?php

namespace App\Http\Controllers\Staf;

use App\Http\Controllers\Controller;
use App\Models\SppItem;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $sppItems = SppItem::all();
        return view('staf.spp.index', compact('sppItems'));
    }

    public function create()
    {
        return view('staf.spp.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_default' => 'required|numeric|min:0',
        ]);

        SppItem::create($request->only('nama', 'jumlah_default'));

        return redirect()->route('staf.spp.index')->with('success', 'Rincian SPP berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $sppItem = SppItem::findOrFail($id);
        return view('staf.spp.edit', compact('sppItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah_default' => 'required|numeric|min:0',
        ]);

        $item = SppItem::findOrFail($id);
        $item->update($request->only('nama', 'jumlah_default'));

        return redirect()->route('staf.spp.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        SppItem::findOrFail($id)->delete();
        return redirect()->route('staf.spp.index')->with('success', 'Data berhasil dihapus.');
    }
}
