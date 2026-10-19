<?php
namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Servis;
use App\Models\Pelanggan;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private array $namaBulans = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    private array $namaBulansShort = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'Mei',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Agu',
        9 => 'Sep',
        10 => 'Okt',
        11 => 'Nov',
        12 => 'Des',
    ];

    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $pendapatan = Transaksi::whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        $totalServis = Servis::whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)->count();

        $servisSelesai = Servis::whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->where('status', 'selesai')->count();

        $stokMenipis = SparePart::whereColumn('stok', '<=', 'stok_minimum')->count();

        // Chart pendapatan per bulan
        $chartLabels = [];
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLabels[] = $this->namaBulansShort[$i];
            $chartData[] = Transaksi::whereMonth('tanggal_bayar', $i)
                ->whereYear('tanggal_bayar', $tahun)
                ->where('status', 'lunas')
                ->sum('total_bayar');
        }

        $transaksiTerbaru = Transaksi::with(['servis.pelanggan', 'servis.kendaraan'])
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->latest()->take(10)->get();

        $namaBulans = $this->namaBulans;

        return view('owner.laporan.index', compact(
            'pendapatan',
            'totalServis',
            'servisSelesai',
            'stokMenipis',
            'chartData',
            'chartLabels',
            'transaksiTerbaru',
            'bulan',
            'tahun',
            'namaBulans',
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        $pendapatan = Transaksi::whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->where('status', 'lunas')
            ->sum('total_bayar');

        $totalServis = Servis::whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)->count();

        $servisSelesai = Servis::whereMonth('tanggal_masuk', $bulan)
            ->whereYear('tanggal_masuk', $tahun)
            ->where('status', 'selesai')->count();

        $transaksiList = Transaksi::with(['servis.pelanggan', 'servis.kendaraan', 'servis.mekanik'])
            ->whereMonth('tanggal_bayar', $bulan)
            ->whereYear('tanggal_bayar', $tahun)
            ->where('status', 'lunas')
            ->latest()->get();

        $namaBulan = $this->namaBulans[$bulan];

        $pdf = Pdf::loadView('owner.laporan.pdf', compact(
            'pendapatan',
            'totalServis',
            'servisSelesai',
            'transaksiList',
            'namaBulan',
            'tahun',
            'bulan',
        ))->setPaper('a4', 'portrait');

        return $pdf->download("Laporan-{$namaBulan}-{$tahun}.pdf");
    }
}