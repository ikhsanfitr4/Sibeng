<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Servis;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $query = Servis::with(['pelanggan', 'kendaraan', 'mekanik']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_order', 'like', "%$search%")
                    ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', "%$search%"))
                    ->orWhereHas('kendaraan', fn($q) => $q->where('plat_nomor', 'like', "%$search%"))
                    ->orWhereHas('mekanik', fn($q) => $q->where('nama', 'like', "%$search%"));
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_masuk', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_masuk', '<=', $request->sampai);
        }

        $servis = $query->latest()->paginate(10)->withQueryString();
        return view('owner.servis.index', compact('servis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $mekaniks = Mekanik::where('status', 'aktif')->orderBy('nama')->get();
        return view('owner.servis.create', compact('pelanggans', 'mekaniks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'mekanik_id' => 'required|exists:mekaniks,id',
            'keluhan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'biaya_jasa' => 'required|numeric|min:0',
            'status' => 'required|in:antrian,proses,selesai,batal',
        ]);

        $data = $request->all();
        $data['no_order'] = 'SRV-' . str_pad(Servis::count() + 1, 4, '0', STR_PAD_LEFT);

        Servis::create($data);
        return redirect()->route('owner.servis.index')
            ->with('success', 'Data servis berhasil ditambahkan.');
    }

    public function show(Servis $servis)
    {
        $servis->load(['pelanggan', 'kendaraan', 'mekanik', 'transaksi.details.sparePart']);
        return view('owner.servis.show', compact('servis'));
    }

    public function edit(Servis $servis)
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $mekaniks = Mekanik::where('status', 'aktif')->orderBy('nama')->get();
        $kendaraans = Kendaraan::where('pelanggan_id', $servis->pelanggan_id)->get();
        return view('owner.servis.edit', compact('servis', 'pelanggans', 'mekaniks', 'kendaraans'));
    }

    public function update(Request $request, Servis $servis)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'mekanik_id' => 'required|exists:mekaniks,id',
            'keluhan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'biaya_jasa' => 'required|numeric|min:0',
            'status' => 'required|in:antrian,proses,selesai,batal',
        ]);

        $servis->update($request->all());
        return redirect()->route('owner.servis.index')
            ->with('success', 'Data servis berhasil diupdate.');
    }

    public function destroy(Servis $servis)
    {
        $servis->delete();
        return redirect()->route('owner.servis.index')
            ->with('success', 'Servis berhasil dihapus.');
    }
}