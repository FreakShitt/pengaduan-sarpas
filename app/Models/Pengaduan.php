<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lokasi',
        'barang',
        'is_temporary_item',
        'detail_laporan',
        'gambar',
        'status',
        'catatan_admin',
        'catatan_petugas'
    ];

    // Relasi ke User (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke User (petugas yang menangani)
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }
}
