<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    
    protected $fillable = [
        'nama_lokasi',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'nama_lokasi', 'nama_lokasi');
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'lokasi', 'nama_lokasi');
    }
}
