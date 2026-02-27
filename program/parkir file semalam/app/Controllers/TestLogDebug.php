<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;
use App\Models\User;

class TestLogDebug extends BaseController
{
    public function index()
    {
        $logModel = new LogAktivitas();
        $userModel = new User();
        
        echo "<h1>Debug Log Aktivitas</h1>";
        
        // Test 1: Cek database connection
        try {
            $db = \Config\Database::connect();
            echo "<p>✓ Database connection: OK</p>";
        } catch (\Exception $e) {
            echo "<p>✗ Database connection: " . $e->getMessage() . "</p>";
            return;
        }
        
        // Test 2: Cek table structure
        echo "<h2>Table Structure</h2>";
        $query = $db->query("DESCRIBE tb_log_aktivitas");
        echo "<table border='1'><tr><th>Field</th><th>Type</th><th>Null</th></tr>";
        foreach ($query->getResult() as $row) {
            echo "<tr><td>{$row->Field}</td><td>{$row->Type}</td><td>{$row->Null}</td></tr>";
        }
        echo "</table>";
        
        // Test 3: Cek total logs
        $allLogs = $logModel->findAll();
        echo "<h2>Total Logs: " . count($allLogs) . "</h2>";
        
        // Test 4: Test getLogsWithUser method
        echo "<h2>Test getLogsWithUser Method</h2>";
        try {
            $logsWithUser = $logModel->getLogsWithUser(5, 0);
            echo "<p>✓ getLogsWithUser berhasil: " . count($logsWithUser) . " records</p>";
            
            echo "<table border='1'><tr><th>ID</th><th>User ID</th><th>Username</th><th>Activity</th><th>Time</th></tr>";
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
        } catch (\Exception $e) {
            echo "<p>✗ getLogsWithUser error: " . $e->getMessage() . "</p>";
        }
        
        // Test 5: Test manual query
        echo "<h2>Test Manual Query</h2>";
        try {
            $query = $db->query("
                SELECT la.*, u.username, u.nama_lengkap 
                FROM tb_log_aktivitas la 
                LEFT JOIN tb_user u ON la.id_user = u.id_user 
                ORDER BY la.waktu_aktivitas DESC 
                LIMIT 5
            ");
            $results = $query->getResult();
            echo "<p>✓ Manual query berhasil: " . count($results) . " records</p>";
            
            echo "<table border='1'><tr><th>ID</th><th>User ID</th><th>Username</th><th>Activity</th><th>Time</th></tr>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>{$row->id_log}</td>";
                echo "<td>" . ($row->id_user ?? 'NULL') . "</td>";
                echo "<td>" . ($row->username ?? 'NULL') . "</td>";
                echo "<td>{$row->aktivitas}</td>";
                echo "<td>{$row->waktu_aktivitas}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } catch (\Exception $e) {
            echo "<p>✗ Manual query error: " . $e->getMessage() . "</p>";
        }
        
        // Test 6: Test insert log
        echo "<h2>Test Insert Log</h2>";
        try {
            $testLogId = $logModel->logActivity(1, 'Test log dari TestLogDebug controller');
            echo "<p>✓ Insert log berhasil: ID " . $testLogId . "</p>";
        } catch (\Exception $e) {
            echo "<p>✗ Insert log error: " . $e->getMessage() . "</p>";
        }
        
        // Test 7: Cek users
        echo "<h2>Available Users</h2>";
        $users = $userModel->findAll();
        echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Nama</th><th>Role</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id_user']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['nama_lengkap']}</td>";
            echo "<td>{$user['role']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test 8: Test login simulation
        echo "<h2>Test Login Simulation</h2>";
        if ($this->request->getGet('test_login')) {
            $username = $this->request->getGet('username') ?? 'testuser3s';
            $user = $userModel->where('username', $username)->first();
            
            if ($user) {
                // Simulate login log
                $logId = $logModel->logLogin($user['id_user'], $user['username']);
                echo "<p>✓ Login simulation berhasil. Log ID: " . $logId . "</p>";
                
                // Check if log was created
                $recentLog = $logModel->where('id_log', $logId)->first();
                if ($recentLog) {
                    echo "<p>✓ Log terverifikasi: " . $recentLog['aktivitas'] . "</p>";
                } else {
                    echo "<p>✗ Log tidak ditemukan setelah insert</p>";
                }
            } else {
                echo "<p>✗ User tidak ditemukan: " . $username . "</p>";
            }
        } else {
            echo "<p><a href='?test_login=1&username=testuser3s'>Test Login dengan testuser3s</a></p>";
        }
        
        echo "<hr>";
        echo "<p><a href='/dashboard'>Back to Dashboard</a></p>";
    }
}
