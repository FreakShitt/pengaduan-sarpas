<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING DASHBOARD DATA ===\n\n";

// Get all users
$users = \App\Models\User::all();
echo "USERS:\n";
foreach ($users as $user) {
    echo "- ID: {$user->id}, Username: {$user->username}, Role: {$user->role}\n";
}

echo "\n";

// Get pengaduans with user
$pengaduans = \App\Models\Pengaduan::with('user')->get();
echo "PENGADUANS (Total: " . $pengaduans->count() . "):\n";
foreach ($pengaduans as $p) {
    $username = $p->user ? $p->user->username : 'null';
    $detail = substr($p->detail_laporan, 0, 50) . '...';
    echo "- ID: {$p->id}, User: {$username} (user_id: {$p->user_id}), Detail: {$detail}, Status: {$p->status}\n";
}

echo "\n";

// Test specific user's pengaduans (test with user id 3 since Parikesit has data)
$testUser = \App\Models\User::find(3); // Parikesit
if ($testUser) {
    echo "PENGADUANS FOR USER '{$testUser->username}' (id: {$testUser->id}):\n";
    $userPengaduans = \App\Models\Pengaduan::where('user_id', $testUser->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    if ($userPengaduans->isEmpty()) {
        echo "  (No pengaduans found)\n";
    } else {
        echo "  Total: " . $userPengaduans->count() . " pengaduans\n";
        foreach ($userPengaduans as $p) {
            $detail = substr($p->detail_laporan, 0, 40);
            echo "  - ID {$p->id}: {$detail}... (status: {$p->status}, lokasi: {$p->lokasi})\n";
        }
    }
    
    // Test stats
    echo "\n  STATISTIK:\n";
    echo "  - Total: " . $userPengaduans->count() . "\n";
    echo "  - Diajukan: " . $userPengaduans->where('status', 'diajukan')->count() . "\n";
    echo "  - Diproses: " . $userPengaduans->where('status', 'diproses')->count() . "\n";
    echo "  - Selesai: " . $userPengaduans->where('status', 'selesai')->count() . "\n";
    echo "  - Ditolak: " . $userPengaduans->where('status', 'ditolak')->count() . "\n";
}
