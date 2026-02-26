<?php
// Fix user data and test JOIN
$mysqli = new mysqli('localhost', 'root', '', 'parkir');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== Update nama_lengkap for users ===\n";
$mysqli->query('UPDATE tb_user SET nama_lengkap = "Test User 3" WHERE id_user = 1');
$mysqli->query('UPDATE tb_user SET nama_lengkap = "Web Test 4" WHERE id_user = 2');
$mysqli->query('UPDATE tb_user SET nama_lengkap = "Dewasa User" WHERE id_user = 3');
echo "Updated user names\n";

echo "\n=== Check updated user data ===\n";
$result = $mysqli->query('SELECT id_user, username, nama_lengkap, role FROM tb_user ORDER BY id_user');
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_user']}, Username: {$row['username']}, Name: " . ($row['nama_lengkap'] ?? 'NULL') . ", Role: {$row['role']}\n";
}

echo "\n=== Test JOIN again ===\n";
$result = $mysqli->query('
    SELECT la.id_log, la.id_user, la.aktivitas, u.username, u.nama_lengkap 
    FROM tb_log_aktivitas la 
    LEFT JOIN tb_user u ON la.id_user = u.id_user 
    WHERE la.id_log IN (1,2,4,6,8,9,10) 
    ORDER BY la.id_log
');

echo "JOIN Results after fixing names:\n";
while ($row = $result->fetch_assoc()) {
    echo "Log ID: {$row['id_log']}, User: {$row['username']}, Name: " . ($row['nama_lengkap'] ?? 'NULL') . "\n";
}

echo "\n=== Test LogAktivitas Model getLogsWithUser ===\n";
// Test the model method
require_once 'vendor/autoload.php';

$app = new CodeIgniter\CodeIgniter(new \Config\App());
$app->initialize();

try {
    $logModel = new \App\Models\LogAktivitas();
    $logsWithUser = $logModel->getLogsWithUser(5, 0);
    
    echo "Model getLogsWithUser results:\n";
    foreach ($logsWithUser as $log) {
        echo "ID: {$log['id_log']}, User: " . ($log['username'] ?? 'NULL') . ", Name: " . ($log['nama_lengkap'] ?? 'NULL') . ", Activity: {$log['aktivitas']}\n";
    }
} catch (Exception $e) {
    echo "Model error: " . $e->getMessage() . "\n";
}

$mysqli->close();
?>
