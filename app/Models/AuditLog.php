<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'role',
        'aksi',
        'modul',
        'keterangan',
        'ip_address',
        'user_agent',
        'lokasi',
        'browser',
        'os',
        'old_data',
        'new_data',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    const AKSI_LOGIN = 'LOGIN';
    const AKSI_LOGIN_GAGAL = 'LOGIN_GAGAL';
    const AKSI_BACKUP = 'BACKUP';
    const AKSI_LOGOUT = 'LOGOUT';

    public static function catat(string $aksi, string $keterangan = null, $user = null): void
    {
        try {
            $user = $user ?? Auth::user();
            $request = request();
            $userAgent = $request->userAgent();

            self::create([
                'user_id' => $user?->id,
                'nama' => $user?->name ?? 'SYSTEM',
                'email' => $user?->email,
                'role' => $user?->role ?? 'SYSTEM',
                'aksi' => $aksi,
                'modul' => 'AUTH',
                'keterangan' => $keterangan,
                'ip_address' => self::getClientIp($request),
                'user_agent' => $userAgent,
                'lokasi' => self::getLocationText($request),
                'browser' => self::getBrowser($userAgent),
                'os' => self::getOS($userAgent),
                'waktu' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal menyimpan audit log: ' . $e->getMessage());
        }
    }

    public static function getClientIp(Request $request): string
    {
        $ip = $request->header('CF-Connecting-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip();

        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }

        return $ip;
    }

    public static function getBrowser(?string $userAgent): string
    {
        $userAgent = $userAgent ?? '';

        return match (true) {
            str_contains($userAgent, 'Edg') => 'Microsoft Edge',
            str_contains($userAgent, 'OPR') || str_contains($userAgent, 'Opera') => 'Opera',
            str_contains($userAgent, 'Chrome') => 'Google Chrome',
            str_contains($userAgent, 'Firefox') => 'Mozilla Firefox',
            str_contains($userAgent, 'Safari') => 'Safari',
            default => 'Unknown Browser',
        };
    }

    public static function getOS(?string $userAgent): string
    {
        $userAgent = $userAgent ?? '';

        return match (true) {
            str_contains($userAgent, 'Windows NT 10') => 'Windows 10/11',
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Android') => 'Android',
            str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad') => 'iOS',
            str_contains($userAgent, 'Macintosh') || str_contains($userAgent, 'Mac OS') => 'macOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            default => 'Unknown OS',
        };
    }

    public static function getLocationText(Request $request): string
    {
        // Untuk InfinityFree, paling aman isi default dulu.
        // Lokasi otomatis dari IP sering diblokir / tidak stabil di hosting gratis.
        return 'Indonesia';
    }
}