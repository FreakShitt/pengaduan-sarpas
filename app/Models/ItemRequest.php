<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    protected $fillable = [
        'nama_lokasi',
        'nama_barang',
        'deskripsi',
        'requested_by',
        'status',
        'reviewed_by',
        'review_note',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }
}
