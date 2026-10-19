<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $fillable = ['pelanggan_id', 'merk', 'model', 'tahun', 'plat_nomor', 'warna'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}