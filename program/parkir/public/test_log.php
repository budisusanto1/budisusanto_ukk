<?php
// Test log activity via web
// Access this via: http://localhost:8080/test_log.php

// Bootstrap CodeIgniter
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'localhost:8080';

require_once '../vendor/autoload.php';

// Initialize CodeIgniter
$app = new CodeIgniter\CodeIgniter(new \Config\App());
$app->initialize();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Log Aktivitas</title>
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
    <h1>Test Log Aktivitas</h1>
    
    <?php
    try {
        $logModel = new \App\Models\LogAktivitas();
        $userModel = new \App\Models\User();
        
        echo "<h2 class='success'>✅ Models Loaded Successfully</h2>";
        
        // Test 1: Insert test log
        echo "<h2>Test 1: Insert Log Activity</h2>";
        $testId = $logModel->logActivity(1, 'Test log dari web interface');
        echo "<p class='success'>✅ Log inserted with ID: $testId</p>";
        
        // Test 2: Get all logs
        echo "<h2>Test 2: All Logs</h2>";
        $allLogs = $logModel->findAll();
        echo "<p class='info'>Total logs: " . count($allLogs) . "</p>";
        
        // Test 3: Get logs with user info
        echo "<h2>Test 3: Logs with User Info (Latest 10)</h2>";
        $logsWithUser = $logModel->getLogsWithUser(10, 0);
        echo "<p class='info'>Logs with user info: " . count($logsWithUser) . "</p>";
        
        if (!empty($logsWithUser)) {
            echo "<table>";
            echo "<tr><th>ID</th><th>User ID</th><th>Username</th><th>Activity</th><th>Time</th></tr>";
            foreach ($logsWithUser as $log) {
                echo "<tr>";
                echo "<td>{$log['id_log']}</td>";
                echo "<td>" . ($log['id_user'] ?? 'NULL') . "</td>";
                echo "<td>" . ($log['username'] ?? 'NULL') . "</td>";
                echo "<td>{$log['aktivitas']}</td>";
                echo "<td>{$log['waktu_aktivitas']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
        // Test 4: Check users
        echo "<h2>Test 4: Available Users</h2>";
        $users = $userModel->findAll();
        if (!empty($users)) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Name</th><th>Role</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id_user']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['nama_lengkap']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Test 5: Simulate login log
            echo "<h2>Test 5: Simulate Login</h2>";
            $testUser = $users[0];
            $loginLogId = $logModel->logLogin($testUser['id_user'], $testUser['username']);
            echo "<p class='success'>✅ Login simulated for {$testUser['username']}. Log ID: $loginLogId</p>";
            
            // Test 6: Get user logs
            echo "<h2>Test 6: User's Recent Logs</h2>";
            $userLogs = $logModel->getLogsByUser($testUser['id_user'], 5);
            if (!empty($userLogs)) {
                echo "<table>";
                echo "<tr><th>Time</th><th>Activity</th></tr>";
                foreach ($userLogs as $log) {
                    echo "<tr>";
                    echo "<td>{$log['waktu_aktivitas']}</td>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
        echo "<h2 class='success'>✅ All Tests Completed Successfully!</h2>";
        
    } catch (Exception $e) {
        echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
        echo "<pre class='error'>" . $e->getTraceAsString() . "</pre>";
    }
    ?>
    
    <hr>
    <p><a href="../">Back to Home</a> | <a href="/dashboard">Dashboard</a></p>
</body>
</html>
