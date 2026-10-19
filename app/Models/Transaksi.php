<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'no_transaksi',
        'servis_id',
        'total_jasa',
        'total_parts',
        'total_bayar',
        'bayar',
        'kembalian',
        'metode_bayar',
        'status',
        'tanggal_bayar'
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class);
    }
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}