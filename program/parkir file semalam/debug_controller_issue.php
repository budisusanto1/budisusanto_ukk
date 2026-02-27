<?php
// Debug issue di UserController store method

// Bootstrap CodeIgniter untuk testing
require_once '../vendor/autoload.php';

$app = new CodeIgniter\CodeIgniter(new \Config\App());
$app->initialize();

// Simulasi request
$_POST['username'] = 'testuser_debug';
$_POST['password'] = '123456';
$_POST['nama_lengkap'] = 'Debug Test User';

echo "=== DEBUG USER CONTROLLER STORE METHOD ===\n\n";

// Test 1: Check User Model
echo "1. USER MODEL TEST:\n";
try {
    $userModel = new \App\Models\User();
    
    $data = [
        'username' => 'testuser_debug',
        'password' => '123456',
        'nama_lengkap' => 'Debug Test User',
        'role' => 'petugas'
    ];
    
    echo "   Data to save:\n";
    foreach ($data as $key => $value) {
        echo "     $key: $value\n";
    }
    
    // Test validation
    echo "   Testing validation...\n";
    if (!$userModel->validate($data)) {
        $errors = $userModel->errors();
        echo "   ❌ Validation errors:\n";
        foreach ($errors as $field => $error) {
            echo "     $field: $error\n";
        }
    } else {
        echo "   ✅ Validation passed\n";
    }
    
    // Test save
    echo "   Testing save...\n";
    if ($userModel->save($data)) {
        $insertId = $userModel->getInsertID();
        echo "   ✅ Save successful! ID: $insertId\n";
        
        // Clean up
        $db = \Config\Database::connect();
        $db->table('tb_user')->delete($insertId);
        echo "   ✅ Cleanup completed\n";
    } else {
        $errors = $userModel->errors();
        echo "   ❌ Save failed:\n";
        foreach ($errors as $field => $error) {
            echo "     $field: $error\n";
        }
    }
    
} catch (Exception $e) {
    echo "   ❌ Exception: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n";

// Test 2: Check allowed fields
echo "2. ALLOWED FIELDS CHECK:\n";
$userModel = new \App\Models\User();
$allowedFields = $userModel->allowedFields;
echo "   Allowed fields: " . implode(', ', $allowedFields) . "\n";

$data = [
    'username' => 'testuser_debug',
    'password' => '123456', 
    'nama_lengkap' => 'Debug Test User',
    'role' => 'petugas'
];

echo "   Data fields: " . implode(', ', array_keys($data)) . "\n";

// Check if all data fields are allowed
foreach ($data as $key => $value) {
    if (!in_array($key, $allowedFields)) {
        echo "   ❌ Field '$key' not in allowed fields!\n";
    } else {
        echo "   ✅ Field '$key' allowed\n";
    }
}

echo "\n";

// Test 3: Check unique constraint
echo "3. UNIQUE CONSTRAINT TEST:\n";
$db = \Config\Database::connect();

// Check if username already exists
$username = 'testuser_debug';
$result = $db->query("SELECT COUNT(*) as count FROM tb_user WHERE username = '$username'");
$count = $result->fetch_assoc()['count'];
echo "   Username '$username' count: $count\n";

if ($count > 0) {
    echo "   ❌ Username already exists!\n";
} else {
    echo "   ✅ Username available\n";
}

echo "\n";

// Test 4: Check password hashing
echo "4. PASSWORD HASHING TEST:\n";
$password = '123456';
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo "   Original: $password\n";
echo "   Hashed: $hashed\n";
echo "   Hash length: " . strlen($hashed) . "\n";

// Test verification
if (password_verify($password, $hashed)) {
    echo "   ✅ Password verification works\n";
} else {
    echo "   ❌ Password verification failed\n";
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Check if all form fields are being submitted\n";
echo "2. Verify validation rules are not too strict\n";
echo "3. Check for unique constraint violations\n";
echo "4. Ensure password field is included in allowedFields\n";
echo "5. Check if callbacks are interfering with save process\n";
?>
