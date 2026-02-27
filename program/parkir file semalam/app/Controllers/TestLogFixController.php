<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;

class TestLogFixController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitas();
    }

    public function index()
    {
        echo "<h2>Test Log Aktivitas Fix</h2>";
        
        // Test 1: Cek total logs
        echo "<h3>1. Total Logs di Database</h3>";
        try {
            $allLogs = $this->logModel->findAll();
            echo "<p>Total logs: " . count($allLogs) . "</p>";
            
            if (count($allLogs) > 0) {
                echo "<p style='color: green;'>✅ Ada data log di database</p>";
                
                // Tampilkan 5 log terbaru
                echo "<h4>5 Log Terbaru:</h4>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>User</th><th>Aktivitas</th><th>Waktu</th><th>IP</th></tr>";
                
                $recentLogs = array_slice($allLogs, -5);
                foreach ($recentLogs as $log) {
                    echo "<tr>";
                    echo "<td>{$log['id_log']}</td>";
                    echo "<td>ID: {$log['id_user']}</td>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "<td>{$log['waktu_aktivitas']}</td>";
                    echo "<td>{$log['ip_address']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: orange;'>⚠️ Belum ada data log di database</p>";
                echo "<p>Mari kita buat beberapa test log...</p>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
        }
        
        // Test 2: Test Log Activity
        echo "<h3>2. Test Log Activity</h3>";
        
        $testActivities = [
            'Test login user',
            'Test akses dashboard',
            'Test CRUD operation',
            'Test search data'
        ];
        
        foreach ($testActivities as $activity) {
            $result = $this->logModel->logActivity(1, $activity);
            echo "<p>Log '$activity': " . ($result ? '✅' : '❌') . "</p>";
        }
        
        // Test 3: Test getLogsWithUser
        echo "<h3>3. Test getLogsWithUser</h3>";
        try {
            $logs = $this->logModel->getLogsWithUser(10, 0);
            echo "<p>getLogsWithUser result: " . count($logs) . " logs</p>";
            
            if (!empty($logs)) {
                echo "<h4>Hasil getLogsWithUser:</h4>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>Username</th><th>Nama</th><th>Aktivitas</th><th>Waktu</th></tr>";
                
                foreach ($logs as $log) {
                    echo "<tr>";
                    echo "<td>{$log['id_log']}</td>";
                    echo "<td>" . ($log['username'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($log['nama_lengkap'] ?? 'N/A') . "</td>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "<td>{$log['waktu_aktivitas']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error getLogsWithUser: " . $e->getMessage() . "</p>";
        }
        
        // Test 4: Test Search
        echo "<h3>4. Test Search Logs</h3>";
        try {
            $searchResults = $this->logModel->searchLogs('test');
            echo "<p>Search 'test' result: " . count($searchResults) . " logs</p>";
            
            if (!empty($searchResults)) {
                echo "<h4>Hasil Search:</h4>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>ID</th><th>Aktivitas</th><th>Waktu</th></tr>";
                
                foreach ($searchResults as $log) {
                    echo "<tr>";
                    echo "<td>{$log['id_log']}</td>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "<td>{$log['waktu_aktivitas']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error searchLogs: " . $e->getMessage() . "</p>";
        }
        
        echo "<br><br>";
        echo "<a href='/log-aktivitas'>Lihat Log Aktivitas</a>";
        echo " | ";
        echo "<a href='/test-area'>Test Area CRUD</a>";
        echo " | ";
        echo "<a href='/dashboard'>Dashboard</a>";
    }
}
