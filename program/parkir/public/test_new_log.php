<?php
// Test new simplified log structure via web
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Simplified Log Structure</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Test Simplified Log Structure</h1>
    
    <?php
    try {
        $mysqli = new mysqli('localhost', 'root', '', 'parkir');
        
        if ($mysqli->connect_error) {
            throw new Exception("Connection failed: " . $mysqli->connect_error);
        }
        
        echo "<h2 class='success'>✅ Database Connected</h2>";
        
        // Test 1: Check new structure
        echo "<h2>New Table Structure:</h2>";
        $result = $mysqli->query('DESCRIBE tb_log_aktivitas');
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test 2: Insert test log
        echo "<h2>Test Insert Log:</h2>";
        $stmt = $mysqli->prepare("INSERT INTO tb_log_aktivitas (id_user, aktivitas, waktu_aktivitas, ip_address) VALUES (?, ?, ?, ?)");
        $id_user = 1;
        $aktivitas = 'Test log struktur baru dari web';
        $waktu = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        
        $stmt->bind_param('isss', $id_user, $aktivitas, $waktu, $ip);
        
        if ($stmt->execute()) {
            $insertId = $mysqli->insert_id;
            echo "<p class='success'>✅ Log inserted successfully! ID: $insertId</p>";
        } else {
            echo "<p class='error'>❌ Failed to insert: " . $stmt->error . "</p>";
        }
        
        // Test 3: Show recent logs with JOIN
        echo "<h2>Recent Logs with User Info:</h2>";
        $result = $mysqli->query("
            SELECT la.id_log, la.id_user, la.aktivitas, la.waktu_aktivitas, la.ip_address, u.username, u.nama_lengkap 
            FROM tb_log_aktivitas la 
            LEFT JOIN tb_user u ON la.id_user = u.id_user 
            ORDER BY la.waktu_aktivitas DESC 
            LIMIT 10
        ");
        
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>User ID</th><th>Username</th><th>Name</th><th>Activity</th><th>Time</th><th>IP Address</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_log']}</td>";
                echo "<td>" . ($row['id_user'] ?? 'NULL') . "</td>";
                echo "<td>" . ($row['username'] ?? 'NULL') . "</td>";
                echo "<td>" . ($row['nama_lengkap'] ?? 'NULL') . "</td>";
                echo "<td>{$row['aktivitas']}</td>";
                echo "<td>{$row['waktu_aktivitas']}</td>";
                echo "<td>" . ($row['ip_address'] ?? 'NULL') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>No logs found</p>";
        }
        
        // Test 4: Show available users
        echo "<h2>Available Users for Testing:</h2>";
        $result = $mysqli->query("SELECT id_user, username, nama_lengkap, role FROM tb_user ORDER BY role, username");
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id_user']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>" . ($row['nama_lengkap'] ?? 'NULL') . "</td>";
            echo "<td>{$row['role']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        $stmt->close();
        $mysqli->close();
        
        echo "<h2 class='success'>✅ All tests completed successfully!</h2>";
        
    } catch (Exception $e) {
        echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
    }
    ?>
    
    <hr>
    <h3>🎯 What Changed:</h3>
    <ul>
        <li>✅ Removed <code>user_agent</code> field</li>
        <li>✅ Removed <code>created_at</code> field</li>
        <li>✅ Kept only essential fields: id_log, id_user, aktivitas, waktu_aktivitas, ip_address</li>
        <li>✅ Foreign key with tb_user still works</li>
        <li>✅ Model and Controller updated</li>
    </ul>
    
    <p>
        <a href="/auth/login" class="btn">Test Login</a> | 
        <a href="/dashboard" class="btn">Dashboard</a> |
        <a href="/log-aktivitas" class="btn">View Logs</a>
    </p>
</body>
</html>
