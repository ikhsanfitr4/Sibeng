<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = ['nama', 'telepon', 'email', 'alamat'];

    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}