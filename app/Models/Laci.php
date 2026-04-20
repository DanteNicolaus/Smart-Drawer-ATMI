<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laci extends Model
{
    use HasFactory;

    protected $table = 'laci';

    protected $fillable = [
        'kode_laci',
        'nama_laci',
        'lokasi',
        'deskripsi',
        'status',
        'lab_id',
    ];

    public function alat()
    {
        return $this->hasMany(Alat::class);
    }

    public function jumlahAlatTersedia()
    {
        return $this->alat()->where('jumlah_tersedia', '>', 0)->count();
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }
}