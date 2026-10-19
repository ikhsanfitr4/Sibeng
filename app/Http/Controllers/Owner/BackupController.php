<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class BackupController extends Controller
{
    private string $backupFolder = 'backup';

    public function index()
    {
        $path = public_path($this->backupFolder);

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $files = scandir($path);
        $backups = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== 'zip') continue;

            $fullPath = $path . '/' . $file;

            $backups[] = [
                'nama' => $file,
                'path' => $file,
                'ukuran' => $this->formatBytes(filesize($fullPath)),
                'tanggal' => date('d/m/Y H:i:s', filemtime($fullPath)),
                'timestamp' => filemtime($fullPath),
            ];
        }

        usort($backups, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        return view('owner.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $folder = public_path($this->backupFolder);

            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }

            $time = date('Y-m-d_H-i-s');
            $sqlFile = $folder . "/backup_$time.sql";
            $zipFile = $folder . "/backup_$time.zip";

            // 🔥 EXPORT DATABASE (PURE PHP)
            $dbName = env('DB_DATABASE');
            $tables = DB::select('SHOW TABLES');

            $sql = "";

            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];

                // CREATE TABLE
                $create = DB::select("SHOW CREATE TABLE `$tableName`");
                $sql .= "\n\n" . $create[0]->{'Create Table'} . ";\n\n";

                // DATA
                $rows = DB::table($tableName)->get();

                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        return isset($value) ? "'" . addslashes($value) . "'" : "NULL";
                    }, (array) $row);

                    $sql .= "INSERT INTO `$tableName` VALUES (" . implode(',', $values) . ");\n";
                }
            }

            file_put_contents($sqlFile, $sql);

            // 🔥 ZIP FILE
            $zip = new ZipArchive();

            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($sqlFile, basename($sqlFile));
                $zip->close();

                unlink($sqlFile); // hapus .sql setelah zip
            } else {
                throw new \Exception('Gagal membuat ZIP');
            }

            AuditLog::catat('BACKUP', 'Backup database berhasil dibuat');

            return back()->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal backup: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $file = $request->file;
        $path = public_path($this->backupFolder . '/' . $file);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        return response()->download($path);
    }

    public function destroy(Request $request)
    {
        $file = $request->file;
        $path = public_path($this->backupFolder . '/' . $file);

        if (file_exists($path)) {
            unlink($path);
            AuditLog::catat('HAPUS_BACKUP', 'Hapus backup: ' . $file);
            return back()->with('success', 'File berhasil dihapus');
        }

        return back()->with('error', 'File tidak ditemukan');
    }

    private function formatBytes($bytes): string
    {
        if ($bytes >= 1073741824)
            return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)
            return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)
            return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}