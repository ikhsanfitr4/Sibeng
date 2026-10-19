<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Servis;
use App\Models\SparePart;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['servis.pelanggan', 'servis.kendaraan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%$search%")
                    ->orWhereHas('servis', fn($q) => $q->where('no_order', 'like', "%$search%"))
                    ->orWhereHas('servis.pelanggan', fn($q) => $q->where('nama', 'like', "%$search%"));
            });
        }

        if ($request->filled('metode')) {
            $query->where('metode_bayar', $request->metode);
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();
        return view('owner.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $servisList = Servis::with(['pelanggan', 'kendaraan'])
            ->where('status', 'selesai')
            ->whereDoesntHave('transaksi')
            ->get();
        $spareParts = SparePart::where('stok', '>', 0)->get();
        return view('owner.transaksi.create', compact('servisList', 'spareParts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'servis_id' => 'required|exists:servis,id',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'bayar' => 'required|numeric|min:0',
            'parts' => 'nullable|array',
            'parts.*.spare_part_id' => 'exists:spare_parts,id',
            'parts.*.qty' => 'integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $servis = Servis::findOrFail($request->servis_id);
            $total_parts = 0;
            $details = [];

            if ($request->parts) {
                foreach ($request->parts as $part) {
                    if (empty($part['spare_part_id']))
                        continue;
                    $sp = SparePart::findOrFail($part['spare_part_id']);
                    $subtotal = $sp->harga_jual * $part['qty'];
                    $total_parts += $subtotal;
                    $details[] = [
                        'spare_part_id' => $sp->id,
                        'qty' => $part['qty'],
                        'harga_satuan' => $sp->harga_jual,
                        'subtotal' => $subtotal,
                    ];
                    // Kurangi stok
                    $sp->decrement('stok', $part['qty']);
                }
            }

            $total_bayar = $servis->biaya_jasa + $total_parts;
            $kembalian = $request->bayar - $total_bayar;

            $transaksi = Transaksi::create([
                'no_transaksi' => 'TRX-' . str_pad(Transaksi::count() + 1, 4, '0', STR_PAD_LEFT),
                'servis_id' => $servis->id,
                'total_jasa' => $servis->biaya_jasa,
                'total_parts' => $total_parts,
                'total_bayar' => $total_bayar,
                'bayar' => $request->bayar,
                'kembalian' => max(0, $kembalian),
                'metode_bayar' => $request->metode_bayar,
                'status' => 'lunas',
                'tanggal_bayar' => now(),
            ]);

            foreach ($details as $d) {
                $d['transaksi_id'] = $transaksi->id;
                TransaksiDetail::create($d);
            }
        });

        return redirect()->route('owner.transaksi.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['servis.pelanggan', 'servis.kendaraan', 'servis.mekanik', 'details.sparePart']);
        return view('owner.transaksi.show', compact('transaksi'));
    }

    public function print(Transaksi $transaksi)
    {
        $transaksi->load(['servis.pelanggan', 'servis.kendaraan', 'servis.mekanik', 'details.sparePart']);
        return view('owner.transaksi.print', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        return redirect()->route('owner.transaksi.index');
    }
    public function update(Request $request, Transaksi $transaksi)
    {
        return redirect()->route('owner.transaksi.index');
    }
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('owner.transaksi.index')->with('success', 'Transaksi dihapus.');
    }
}