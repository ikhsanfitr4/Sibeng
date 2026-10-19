<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = ['nama', 'kode', 'kategori', 'stok', 'stok_minimum', 'harga_beli', 'harga_jual'];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
}