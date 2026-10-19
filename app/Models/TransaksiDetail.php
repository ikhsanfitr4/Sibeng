<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = ['transaksi_id', 'spare_part_id', 'qty', 'harga_satuan', 'subtotal'];

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}