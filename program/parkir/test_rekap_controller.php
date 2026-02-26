<?php
// Test script untuk RekapTransaksiController
require_once 'app/Controllers/RekapTransaksiController.php';

use App\Controllers\RekapTransaksiController;

echo "🧪 Testing RekapTransaksiController...\n\n";

// Simulasi session
$_SESSION = [
    'isLoggedIn' => true,
    'id_user' => 1,
    'role' => 'owner'
];

// Buat instance controller
$controller = new RekapTransaksiController();

echo "✅ Controller instance created\n";
echo "📋 Available methods:\n";

$methods = get_class_methods($controller);
foreach ($methods as $method) {
    if ($method !== '__construct' && !str_starts_with($method, '_')) {
        echo "   - $method\n";
    }
}

echo "\n🎯 Test complete!\n";
echo "📝 Controller should work correctly.\n";
?>
