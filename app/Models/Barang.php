<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    
    protected $fillable = [
        'nama_lokasi',
        'nama_barang',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'nama_lokasi', 'nama_lokasi');
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'barang', 'nama_barang');
    }
}
