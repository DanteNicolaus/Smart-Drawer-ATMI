<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $table = 'lab';
    protected $fillable = ['kode_lab', 'nama_lab', 'lokasi', 'deskripsi', 'status'];

    public function lacis()
    {
        return $this->hasMany(Laci::class, 'lab_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function jumlahAlatTersedia()
    {
        return $this->lacis()
            ->with('alat')
            ->get()
            ->flatMap(fn($laci) => $laci->alat->where('status', 'tersedia'))
            ->count();
    }

    public function jumlahAlatTotal()
    {
        return $this->lacis()
            ->withCount('alat')
            ->get()
            ->sum('alat_count');
    }
}