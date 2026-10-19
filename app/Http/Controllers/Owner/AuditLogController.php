<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::latest('waktu');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('ip_address', 'like', "%$s%")
                  ->orWhere('keterangan', 'like', "%$s%")
                  ->orWhere('modul', 'like', "%$s%");
            });
        }

        if ($request->filled('aksi')) $query->where('aksi', $request->aksi);
        if ($request->filled('dari')) $query->whereDate('waktu', '>=', $request->dari);
        if ($request->filled('sampai')) $query->whereDate('waktu', '<=', $request->sampai);

        $logs = $query->paginate(15)->withQueryString();

        $totalLogin = AuditLog::where('aksi', 'LOGIN')->count();
        $totalLogout = AuditLog::where('aksi', 'LOGOUT')->count();
        $totalGagal = AuditLog::where('aksi', 'LOGIN_GAGAL')->count();
        $totalHariIni = AuditLog::whereDate('waktu', today())->count();

       return view('owner.audit-log.index', compact(
    'logs',
    'totalLogin',
    'totalLogout',
    'totalGagal',
    'totalHariIni'
	));
    }

    public function export(Request $request)
    {
        $query = AuditLog::latest('waktu');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('ip_address', 'like', "%$s%")
                  ->orWhere('keterangan', 'like', "%$s%")
                  ->orWhere('modul', 'like', "%$s%");
            });
        }

        if ($request->filled('aksi')) $query->where('aksi', $request->aksi);
        if ($request->filled('dari')) $query->whereDate('waktu', '>=', $request->dari);
        if ($request->filled('sampai')) $query->whereDate('waktu', '<=', $request->sampai);

        $logs = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="audit-log-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID', 'Nama', 'Email', 'Role', 'Aksi', 'Modul',
                'Keterangan', 'IP Address', 'Lokasi', 'Browser', 'OS', 'Waktu',
            ]);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->nama ?? '-',
                    $log->email ?? '-',
                    $log->role ?? '-',
                    $log->aksi,
                    $log->modul ?? '-',
                    $log->keterangan ?? '-',
                    $log->ip_address ?? '-',
                    $log->lokasi ?? '-',
                    $log->browser ?? '-',
                    $log->os ?? '-',
                    $log->waktu,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Request $request)
    {
        AuditLog::truncate();

        return redirect()->route('owner.audit-log.index')
            ->with('success', 'Semua log berhasil dihapus.');
    }
}