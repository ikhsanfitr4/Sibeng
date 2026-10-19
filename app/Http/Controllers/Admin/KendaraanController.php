<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function create(Pelanggan $pelanggan)
    {
        return view('admin.kendaraan.create', compact('pelanggan'));
    }

    public function store(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'nullable|digits:4',
            'plat_nomor' => 'required|string|unique:kendaraans,plat_nomor',
            'warna' => 'nullable|string|max:30',
        ]);

        Kendaraan::create([
            'pelanggan_id' => $pelanggan->id,
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'plat_nomor' => strtoupper($request->plat_nomor),
            'warna' => $request->warna,
        ]);

        return redirect()->route('admin.pelanggan.show', $pelanggan)
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Pelanggan $pelanggan, Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('pelanggan', 'kendaraan'));
    }

    public function update(Request $request, Pelanggan $pelanggan, Kendaraan $kendaraan)
    {
        $request->validate([
            'merk' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'nullable|digits:4',
            'plat_nomor' => 'required|string|unique:kendaraans,plat_nomor,' . $kendaraan->id,
            'warna' => 'nullable|string|max:30',
        ]);

        $kendaraan->update([
            'merk' => $request->merk,
            'model' => $request->model,
            'tahun' => $request->tahun,
            'plat_nomor' => strtoupper($request->plat_nomor),
            'warna' => $request->warna,
        ]);

        return redirect()->route('admin.pelanggan.show', $pelanggan)
            ->with('success', 'Kendaraan berhasil diupdate.');
    }

    public function destroy(Pelanggan $pelanggan, Kendaraan $kendaraan)
    {
        $kendaraan->delete();
        return redirect()->route('admin.pelanggan.show', $pelanggan)
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}