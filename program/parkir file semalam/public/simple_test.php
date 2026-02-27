<?php
// Simple database test for log activity
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Log Test</title>
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
    <h1>Simple Database Log Test</h1>
    
    <?php
    try {
        // Direct database connection
        $mysqli = new mysqli('localhost', 'root', '', 'parkir');
        
        if ($mysqli->connect_error) {
            throw new Exception("Connection failed: " . $mysqli->connect_error);
        }
        
        echo "<h2 class='success'>✅ Database Connected</h2>";
        
        // Test 1: Check table
        $result = $mysqli->query("SHOW TABLES LIKE 'tb_log_aktivitas'");
        if ($result->num_rows > 0) {
            echo "<h2 class='success'>✅ Table tb_log_aktivitas exists</h2>";
        } else {
            echo "<h2 class='error'>❌ Table tb_log_aktivitas not found</h2>";
        }
        
        // Test 2: Insert test log
        $stmt = $mysqli->prepare("INSERT INTO tb_log_aktivitas (id_user, aktivitas, waktu_aktivitas, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        $id_user = 1;
        $aktivitas = 'Test log dari simple_test.php';
        $waktu = date('Y-m-d H:i:s');
        $ip = '127.0.0.1';
        $user_agent = 'Simple Test Script';
        
        $stmt->bind_param('issss', $id_user, $aktivitas, $waktu, $ip, $user_agent);
        
        if ($stmt->execute()) {
            $insertId = $mysqli->insert_id;
            echo "<h2 class='success'>✅ Test log inserted. ID: $insertId</h2>";
        } else {
            echo "<h2 class='error'>❌ Failed to insert log: " . $stmt->error . "</h2>";
        }
        
        // Test 3: Show recent logs
        $result = $mysqli->query("
            SELECT la.*, u.username, u.nama_lengkap 
            FROM tb_log_aktivitas la 
            LEFT JOIN tb_user u ON la.id_user = u.id_user 
            ORDER BY la.waktu_aktivitas DESC 
            LIMIT 10
        ");
        
        echo "<h2>Recent 10 Logs:</h2>";
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>User ID</th><th>Username</th><th>Activity</th><th>Time</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_log']}</td>";
                echo "<td>" . ($row['id_user'] ?? 'NULL') . "</td>";
                echo "<td>" . ($row['username'] ?? 'NULL') . "</td>";
                echo "<td>{$row['aktivitas']}</td>";
                echo "<td>{$row['waktu_aktivitas']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>No logs found</p>";
        }
        
        // Test 4: Check users
        $result = $mysqli->query("SELECT id_user, username, nama_lengkap, role FROM tb_user LIMIT 5");
        echo "<h2>Available Users:</h2>";
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id_user']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['nama_lengkap']}</td>";
                echo "<td>{$row['role']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='info'>No users found</p>";
        }
        
        $stmt->close();
        $mysqli->close();
        
        echo "<h2 class='success'>✅ All tests completed!</h2>";
        
    } catch (Exception $e) {
        echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
    }
    ?>
    
    <hr>
    <p><a href="/">Back to Home</a> | <a href="/dashboard">Dashboard</a></p>
</body>
</html>
