<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'kategori',
        'jumlah_total',
        'jumlah_tersedia',
        'kondisi',
        'lokasi_penyimpanan',
        'foto',
        'status',
        'laci_id',
    ];

    /**
     * Relasi dengan Peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    /**
     * Relasi dengan Laci (banyak alat milik 1 laci)
     */
    public function laci()
    {
        return $this->belongsTo(Laci::class);
    }

    /**
     * Accessor untuk status ketersediaan
     */
    public function getIsAvailableAttribute()
    {
        return $this->jumlah_tersedia > 0;
    }

    /**
     * Scope untuk alat yang tersedia
     */
    public function scopeAvailable($query)
    {
        return $query->where('jumlah_tersedia', '>', 0)
                     ->where('status', 'tersedia');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Scope untuk filter berdasarkan laci
     */
    public function scopeByLaci($query, $laciId)
    {
        return $query->where('laci_id', $laciId);
    }
    
}