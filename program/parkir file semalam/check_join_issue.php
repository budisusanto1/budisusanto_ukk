<?php
// Check why JOIN is not working
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== Check tb_user structure ===\n";
$result = $mysqli->query('DESCRIBE tb_user');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . "\n";
}

echo "\n=== Check tb_log_aktivitas structure ===\n";
$result = $mysqli->query('DESCRIBE tb_log_aktivitas');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - ' . $row['Null'] . "\n";
}

echo "\n=== Check data in tb_user ===\n";
$result = $mysqli->query('SELECT id_user, username, nama_lengkap FROM tb_user LIMIT 5');
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_user']}, Username: {$row['username']}, Name: " . ($row['nama_lengkap'] ?? 'NULL') . "\n";
}

echo "\n=== Test JOIN query ===\n";
$result = $mysqli->query("
    SELECT la.id_log, la.id_user, la.aktivitas, u.username, u.nama_lengkap 
    FROM tb_log_aktivitas la 
    LEFT JOIN tb_user u ON la.id_user = u.id_user 
    WHERE la.id_log IN (1,2,4,6,8,9,10)
    ORDER BY la.id_log
");

echo "JOIN Results:\n";
while ($row = $result->fetch_assoc()) {
    echo "Log ID: {$row['id_log']}, User ID: {$row['id_user']}, Username: " . ($row['username'] ?? 'NULL') . ", Name: " . ($row['nama_lengkap'] ?? 'NULL') . "\n";
}

echo "\n=== Check if id_user values match ===\n";
$result = $mysqli->query('SELECT id_log, id_user FROM tb_log_aktivitas WHERE id_log IN (1,2,4,6,8,9,10)');
$logUsers = [];
while ($row = $result->fetch_assoc()) {
    $logUsers[] = $row;
    echo "Log ID: {$row['id_log']} -> User ID: {$row['id_user']}\n";
}

echo "\n=== Check if these user IDs exist in tb_user ===\n";
foreach ($logUsers as $logUser) {
    $userId = $logUser['id_user'];
    $result = $mysqli->query("SELECT id_user, username FROM tb_user WHERE id_user = $userId");
    $user = $result->fetch_assoc();
    echo "User ID $userId: " . ($user ? "Found - {$user['username']}" : "NOT FOUND") . "\n";
}

echo "\n=== Check foreign key constraints ===\n";
$result = $mysqli->query("
    SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = 'parkir' 
    AND (TABLE_NAME = 'tb_log_aktivitas' OR TABLE_NAME = 'tb_user')
    AND REFERENCED_TABLE_NAME IS NOT NULL
");

while ($row = $result->fetch_assoc()) {
    echo "Table: {$row['TABLE_NAME']}, Column: {$row['COLUMN_NAME']}, FK: {$row['CONSTRAINT_NAME']}, Ref: {$row['REFERENCED_TABLE_NAME']}.{$row['REFERENCED_COLUMN_NAME']}\n";
}

$mysqli->close();
?>
