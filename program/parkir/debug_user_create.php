<?php
// Debug khusus untuk create user
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== DEBUG USER CREATE ===\n\n";

// Test 1: Check table structure
echo "1. TABLE STRUCTURE:\n";
$result = $mysqli->query("DESCRIBE tb_user");
while ($row = $result->fetch_assoc()) {
    echo "   {$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']}\n";
}

echo "\n";

// Test 2: Test direct insert
echo "2. DIRECT INSERT TEST:\n";
$username = 'debug_user_' . time();
$password = password_hash('123456', PASSWORD_DEFAULT);
$nama_lengkap = 'Debug User';
$role = 'petugas';

echo "   Username: $username\n";
echo "   Password Hash: " . substr($password, 0, 20) . "...\n";
echo "   Nama Lengkap: $nama_lengkap\n";
echo "   Role: $role\n";

$stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $username, $password, $nama_lengkap, $role);

if ($stmt->execute()) {
    $userId = $mysqli->insert_id;
    echo "   ✅ SUCCESS: User created with ID: $userId\n";
    
    // Verify insert
    $result = $mysqli->query("SELECT * FROM tb_user WHERE id_user = $userId");
    $user = $result->fetch_assoc();
    echo "   ✅ VERIFICATION: Found user {$user['username']} in database\n";
    
    // Clean up
    $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    echo "   ✅ CLEANUP: Test user deleted\n";
    
} else {
    echo "   ❌ FAILED: " . $stmt->error . "\n";
    echo "   ❌ SQLSTATE: " . $stmt->sqlstate . "\n";
}

$stmt->close();

echo "\n";

// Test 3: Test with different data types
echo "3. DATA TYPE TEST:\n";
$test_cases = [
    [
        'username' => 'test1',
        'password' => '123456',
        'nama_lengkap' => 'Test User 1',
        'role' => 'petugas'
    ],
    [
        'username' => 'test2',
        'password' => 'password123',
        'nama_lengkap' => '',
        'role' => 'admin'
    ],
    [
        'username' => 'test3',
        'password' => 'mypass',
        'nama_lengkap' => 'Test User 3',
        'role' => 'superadmin'
    ]
];

foreach ($test_cases as $i => $test_case) {
    echo "   Test Case " . ($i + 1) . ":\n";
    
    $username = $test_case['username'] . '_' . time();
    $password = password_hash($test_case['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $test_case['nama_lengkap'];
    $role = $test_case['role'];
    
    echo "     Username: $username\n";
    echo "     Password: {$test_case['password']} (hashed)\n";
    echo "     Nama: '$nama_lengkap'\n";
    echo "     Role: $role\n";
    
    $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $username, $password, $nama_lengkap, $role);
    
    if ($stmt->execute()) {
        $userId = $mysqli->insert_id;
        echo "     ✅ SUCCESS: ID $userId\n";
        
        // Clean up
        $stmt2 = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
        $stmt2->bind_param('i', $userId);
        $stmt2->execute();
        $stmt2->close();
    } else {
        echo "     ❌ FAILED: " . $stmt->error . "\n";
    }
    
    $stmt->close();
}

echo "\n";

// Test 4: Check for constraints
echo "4. CONSTRAINTS CHECK:\n";
$result = $mysqli->query("
    SELECT CONSTRAINT_NAME, CONSTRAINT_TYPE, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = 'parkir' 
    AND TABLE_NAME = 'tb_user'
");

while ($row = $result->fetch_assoc()) {
    echo "   Constraint: {$row['CONSTRAINT_NAME']} - {$row['CONSTRAINT_TYPE']}\n";
    if ($row['REFERENCED_TABLE_NAME']) {
        echo "   References: {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}\n";
    }
}

echo "\n";

// Test 5: Check current users
echo "5. CURRENT USERS:\n";
$result = $mysqli->query("SELECT id_user, username, nama_lengkap, role FROM tb_user ORDER BY id_user");
while ($row = $result->fetch_assoc()) {
    echo "   ID: {$row['id_user']}, Username: {$row['username']}, Name: '{$row['nama_lengkap']}', Role: {$row['role']}\n";
}

$mysqli->close();

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. If direct insert works, issue is in controller/model\n";
echo "2. If direct insert fails, issue is in database level\n";
echo "3. Check for unique constraint violations\n";
echo "4. Verify data types match table structure\n";
echo "5. Check for foreign key constraints\n";
?>
