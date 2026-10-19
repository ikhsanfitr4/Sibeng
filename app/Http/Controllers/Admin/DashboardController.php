<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servis;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\SparePart;

class DashboardController extends Controller
{
    public function index()
    {
        $antrianHariIni = Servis::whereDate('tanggal_masuk', today())
            ->whereIn('status', ['antrian', 'proses'])
            ->count();

        $servisSelesai = Servis::whereMonth('tanggal_masuk', now()->month)
            ->where('status', 'selesai')->count();

        $totalSparePart = SparePart::count();
        $totalServis = Servis::whereMonth('tanggal_masuk', now()->month)->count();

        $antrianAktif = Servis::with(['pelanggan', 'kendaraan', 'mekanik'])
            ->whereIn('status', ['antrian', 'proses'])
            ->latest()->take(8)->get();

        $servisTerbaru = Servis::with(['pelanggan', 'kendaraan', 'mekanik'])
            ->latest()->take(6)->get();

        $stokMenipis = SparePart::whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok')->get();

        return view('admin.dashboard', compact(
            'antrianHariIni',
            'servisSelesai',
            'totalSparePart',
            'totalServis',
            'antrianAktif',
            'servisTerbaru',
            'stokMenipis',
        ));
    }
}