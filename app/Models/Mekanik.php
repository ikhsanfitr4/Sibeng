<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    protected $fillable = ['nama', 'telepon', 'alamat', 'status'];

    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}