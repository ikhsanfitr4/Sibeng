<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Servis;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Mekanik;
use App\Models\SparePart;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServis = Servis::count();
        $totalPelanggan = Pelanggan::count();
        $totalMekanik = Mekanik::where('status', 'aktif')->count();

        $antrianHariIni = Servis::whereDate('tanggal_masuk', today())
            ->whereIn('status', ['antrian', 'proses'])
            ->count();

        $pendapatanBulanIni = Transaksi::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        $pendapatanBulanLalu = Transaksi::whereMonth('tanggal_bayar', now()->subMonth()->month)
            ->whereYear('tanggal_bayar', now()->subMonth()->year)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        $persenPendapatan = $pendapatanBulanLalu > 0
            ? round((($pendapatanBulanIni - $pendapatanBulanLalu) / $pendapatanBulanLalu) * 100, 1)
            : 0;

        $stokMenipis = SparePart::whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok')->get();

        $servisTerbaru = Servis::with(['pelanggan', 'kendaraan', 'mekanik'])
            ->latest()->take(6)->get();

        $antrianAktif = Servis::with(['pelanggan', 'kendaraan', 'mekanik'])
            ->whereIn('status', ['antrian', 'proses'])
            ->whereDate('tanggal_masuk', today())
            ->latest()->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $chartLabels[] = $bulan->translatedFormat('M Y');
            $chartData[] = Transaksi::whereMonth('tanggal_bayar', $bulan->month)
                ->whereYear('tanggal_bayar', $bulan->year)
                ->where('status', 'lunas')
                ->sum('total_bayar');
        }

        $transaksiTerbaru = Transaksi::with(['servis.pelanggan', 'servis.kendaraan'])
            ->where('status', 'lunas')
            ->latest()->take(5)->get();

        return view('owner.dashboard', compact(
            'totalServis',
            'totalPelanggan',
            'totalMekanik',
            'antrianHariIni',
            'pendapatanBulanIni',
            'persenPendapatan',
            'stokMenipis',
            'servisTerbaru',
            'antrianAktif',
            'chartLabels',
            'chartData',
            'transaksiTerbaru',
        ));
    }
}