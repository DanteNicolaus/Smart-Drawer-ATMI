<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nim',
        'jurusan',
        'no_hp',
        'email',
        'password',
        'role',
        'lab_id',           // ← TAMBAH INI
        'koin',
        'created_by',
        'google_id',
        'avatar',
        'google_login_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'koin'                 => 'integer',
            'google_login_enabled' => 'boolean',
        ];
    }

    // ==================== RELASI ====================

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    // ← TAMBAH RELASI INI
    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    // ==================== ROLE CHECK ====================

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isUserAdmin()
    {
        return $this->role === 'user_admin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function hasAdminAccess()
    {
        return in_array($this->role, ['admin', 'user_admin', 'super_admin']);
    }

    public function getRoleDisplayName()
    {
        return match($this->role) {
            'user'        => 'User',
            'admin'       => 'Admin Lab',
            'user_admin'  => 'User Admin',
            'super_admin' => 'Super Admin',
            default       => 'Unknown'
        };
    }

    // ==================== KOIN ====================

    public function hasEnoughKoin($jumlah = 1)
    {
        return $this->koin >= $jumlah;
    }

    public function kurangiKoin($jumlah = 1)
    {
        if ($this->koin >= $jumlah) {
            $this->decrement('koin', $jumlah);
            return true;
        }
        return false;
    }

    public function tambahKoin($jumlah = 1)
    {
        $this->increment('koin', $jumlah);
    }

    public function resetKoin()
    {
        $this->update(['koin' => 10]);
    }

    public function getPersentaseKoin()
    {
        return ($this->koin / 10) * 100;
    }
}