<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pengaduan;

Route::get('/test-foto', function () {
    $pengaduans = Pengaduan::whereNotNull('foto_penyelesaian')->get();
    
    if ($pengaduans->count() > 0) {
        foreach ($pengaduans as $p) {
            echo "ID: {$p->id}<br>";
            echo "Status: {$p->status}<br>";
            echo "Foto Size: " . strlen($p->foto_penyelesaian) . " bytes<br>";
            echo "Uploaded: " . ($p->foto_penyelesaian_uploaded_at ?? 'NULL') . "<br>";
            echo "---<br>";
        }
    } else {
        echo "No pengaduan with foto_penyelesaian found.<br>";
        echo "Total pengaduans: " . Pengaduan::count() . "<br>";
    }
});
