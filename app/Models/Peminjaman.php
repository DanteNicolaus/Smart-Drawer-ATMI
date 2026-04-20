<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $kode_peminjaman
 * @property int $user_id
 * @property int $alat_id
 * @property int $jumlah_pinjam
 * @property \Illuminate\Support\Carbon $tanggal_pinjam
 * @property \Illuminate\Support\Carbon $tanggal_kembali_rencana
 * @property \Illuminate\Support\Carbon|null $tanggal_kembali_aktual
 * @property string $keperluan
 * @property string $status
 * @property string|null $catatan_admin
 * @property string|null $catatan_pengembalian
 * @property string|null $kondisi_saat_kembali
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Alat $alat
 * @property-read mixed $status_badge
 * @property-read mixed $status_label
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereAlatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereCatatanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereCatatanPengembalian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereJumlahPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereKeperluan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereKodePeminjaman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereKondisiSaatKembali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereTanggalKembaliAktual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereTanggalKembaliRencana($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereTanggalPinjam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Peminjaman whereUserId($value)
 * @mixin \Eloquent
 */
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'alat_id',
        'jumlah_pinjam',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'keperluan',
        'status',
        'catatan_admin',
        'catatan_pengembalian',
        'kondisi_saat_kembali',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];

    /**
     * Relasi dengan User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan Alat
     */
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    /**
     * Accessor untuk status badge class
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'disetujui' => 'info',
            'ditolak' => 'danger',
            'dipinjam' => 'primary',
            'dikembalikan' => 'success',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    /**
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Persetujuan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipinjam' => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Scope untuk peminjaman berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk peminjaman yang sedang aktif
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['disetujui', 'dipinjam']);
    }

    /**
     * Generate kode peminjaman otomatis
     */
    public static function generateKodePeminjaman()
    {
        $lastPeminjaman = self::latest()->first();
        $lastNumber = $lastPeminjaman ? intval(substr($lastPeminjaman->kode_peminjaman, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return 'PJM' . date('Ymd') . $newNumber;
    }
}
