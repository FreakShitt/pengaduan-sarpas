<?php
/**
 * Quick Login Test Script
 * Run: php test_login.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Testing Login System ===\n\n";

// Test 1: Check if users exist
echo "1. Checking users in database...\n";
$users = User::all();
echo "   Found " . $users->count() . " users\n";

foreach ($users as $user) {
    echo "   - Username: {$user->username}, Role: {$user->role}\n";
}

// Test 2: Verify password hashing
echo "\n2. Testing password verification...\n";
$testUser = User::where('username', 'admin')->first();

if ($testUser) {
    echo "   User 'admin' found!\n";
    echo "   Stored password hash: " . substr($testUser->password, 0, 20) . "...\n";
    
    // Test password
    if (Hash::check('password', $testUser->password)) {
        echo "   ✓ Password 'password' is CORRECT!\n";
    } else {
        echo "   ✗ Password 'password' is INCORRECT!\n";
    }
} else {
    echo "   ✗ User 'admin' not found!\n";
}

// Test 3: Check table structure
echo "\n3. Checking 'user' table structure...\n";
$columns = DB::select("DESCRIBE user");
echo "   Columns in 'user' table:\n";
foreach ($columns as $column) {
    echo "   - {$column->Field} ({$column->Type})\n";
}

echo "\n=== Test Complete ===\n";
echo "\nLogin Credentials:\n";
echo "Username: admin\n";
echo "Password: password\n";
echo "\nOR\n";
echo "Username: siswa\n";
echo "Password: password\n";
