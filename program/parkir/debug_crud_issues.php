<?php
// Debug potensi masalah CRUD
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== DEBUG CRUD ISSUES ===\n\n";

// 1. Check User validation issues
echo "1. USER MODEL VALIDATION ISSUES:\n";
echo "   - g-recaptcha-response in validation rules: " . (strpos('g-recaptcha-response', 'required') !== false ? 'FOUND ❌' : 'OK ✅') . "\n";
echo "   - This will cause validation to fail in non-form contexts\n\n";

// 2. Check table structures
echo "2. TABLE STRUCTURES:\n";

$tables = [
    'tb_user' => 'id_user',
    'tb_kendaraan' => 'id_kendaraan', 
    'tb_tarif' => 'id_tarif',
    'tb_area_parkir' => 'id_area',
    'tb_log_aktivitas' => 'id_log'
];

foreach ($tables as $table => $pk) {
    $result = $mysqli->query("DESCRIBE $table");
    echo "   $table:\n";
    while ($row = $result->fetch_assoc()) {
        $null = $row['Null'] == 'YES' ? 'NULL' : 'NOT NULL';
        echo "     {$row['Field']} - {$row['Type']} - $null\n";
    }
    echo "\n";
}

// 3. Check foreign key constraints
echo "3. FOREIGN KEY CONSTRAINTS:\n";
$result = $mysqli->query("
    SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME, DELETE_RULE
    FROM information_schema.KEY_COLUMN_USAGE kcu
    JOIN information_schema.REFERENTIAL_CONSTRAINTS rc ON kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME
    WHERE kcu.TABLE_SCHEMA = DATABASE() 
    AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
");

while ($row = $result->fetch_assoc()) {
    echo "   {$row['TABLE_NAME']}.{$row['COLUMN_NAME']} → {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']} (ON DELETE {$row['DELETE_RULE']})\n";
}
echo "\n";

// 4. Test actual CRUD operations
echo "4. ACTUAL CRUD TESTS:\n";

// Test User CRUD
echo "   Testing User CRUD:\n";
try {
    // Test Create
    $username = 'debug_user_' . time();
    $password = password_hash('123456', PASSWORD_DEFAULT);
    $nama_lengkap = 'Debug User';
    $role = 'petugas';
    
    $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $username, $password, $nama_lengkap, $role);
    
    if ($stmt->execute()) {
        $userId = $mysqli->insert_id;
        echo "     ✅ User created: $username (ID: $userId)\n";
        
        // Test Update
        $new_nama = 'Updated Debug User';
        $stmt = $mysqli->prepare("UPDATE tb_user SET nama_lengkap = ? WHERE id_user = ?");
        $stmt->bind_param('si', $new_nama, $userId);
        
        if ($stmt->execute()) {
            echo "     ✅ User updated: $new_nama\n";
            
            // Test Delete
            $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
            $stmt->bind_param('i', $userId);
            
            if ($stmt->execute()) {
                echo "     ✅ User deleted\n";
            } else {
                echo "     ❌ User delete failed: " . $stmt->error . "\n";
            }
        } else {
            echo "     ❌ User update failed: " . $stmt->error . "\n";
        }
        $stmt->close();
    } else {
        echo "     ❌ User create failed: " . $stmt->error . "\n";
    }
} catch (Exception $e) {
    echo "     ❌ User CRUD Exception: " . $e->getMessage() . "\n";
}

// Test Kendaraan CRUD
echo "   Testing Kendaraan CRUD:\n";
try {
    $plat_nomor = 'DEBUG-' . time();
    $jenis_kendaraan = 'mobil';
    $warna = 'Merah';
    $pemilik = 'Debug Owner';
    $id_user = 1;
    
    $stmt = $mysqli->prepare("INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, warna, pemilik, id_user) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssi', $plat_nomor, $jenis_kendaraan, $warna, $pemilik, $id_user);
    
    if ($stmt->execute()) {
        $kendaraanId = $mysqli->insert_id;
        echo "     ✅ Kendaraan created: $plat_nomor (ID: $kendaraanId)\n";
        
        // Test Update
        $new_warna = 'Biru';
        $stmt = $mysqli->prepare("UPDATE tb_kendaraan SET warna = ? WHERE id_kendaraan = ?");
        $stmt->bind_param('si', $new_warna, $kendaraanId);
        
        if ($stmt->execute()) {
            echo "     ✅ Kendaraan updated: $new_warna\n";
            
            // Test Delete
            $stmt = $mysqli->prepare("DELETE FROM tb_kendaraan WHERE id_kendaraan = ?");
            $stmt->bind_param('i', $kendaraanId);
            
            if ($stmt->execute()) {
                echo "     ✅ Kendaraan deleted\n";
            } else {
                echo "     ❌ Kendaraan delete failed: " . $stmt->error . "\n";
            }
        } else {
            echo "     ❌ Kendaraan update failed: " . $stmt->error . "\n";
        }
        $stmt->close();
    } else {
        echo "     ❌ Kendaraan create failed: " . $stmt->error . "\n";
    }
} catch (Exception $e) {
    echo "     ❌ Kendaraan CRUD Exception: " . $e->getMessage() . "\n";
}

// 5. Check for potential issues
echo "\n5. POTENTIAL ISSUES FOUND:\n";

// Check if reCAPTCHA is causing issues
echo "   ⚠️  reCAPTCHA validation in User model may cause issues in non-form contexts\n";

// Check if there are missing required fields
echo "   ⚠️  Check if all required fields are properly handled in forms\n";

// Check if foreign keys are causing issues
echo "   ⚠️  Foreign key constraints may prevent delete operations\n";

// Check if timestamps are causing issues
echo "   ⚠️  Timestamp fields may cause issues if not properly handled\n";

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Remove 'g-recaptcha-response' from User model validation rules\n";
echo "2. Ensure all forms include CSRF tokens\n";
echo "3. Check if foreign key constraints are too restrictive\n";
echo "4. Verify all required fields are included in forms\n";
echo "5. Test with different user roles (admin vs superadmin)\n";

$mysqli->close();
?>
