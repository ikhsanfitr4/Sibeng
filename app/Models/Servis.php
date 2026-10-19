<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis'; // ← tambahkan ini

    protected $fillable = [
        'no_order',
        'pelanggan_id',
        'kendaraan_id',
        'mekanik_id',
        'keluhan',
        'diagnosa',
        'status',
        'biaya_jasa',
        'tanggal_masuk',
        'tanggal_selesai',
        'catatan'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class);
    }
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class);
    }
}
