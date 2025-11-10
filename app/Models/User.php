<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Pakai tabel 'user' (bukan default 'users')
    protected $table = 'user';
    
    // Primary key default 'id' (dari $table->id() di migration)
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pengguna',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get pengaduans submitted by this user
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'user_id', 'id');
    }

    /**
     * Get pengaduans handled by this petugas
     */
    public function pengaduansDitangani()
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id', 'id');
    }
}
