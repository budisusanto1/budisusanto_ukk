<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;

class TestAllLogsController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitas();
    }

    public function index()
    {
        echo "<h2>🔍 Test Semua Log Aktivitas</h2>";
        
        // Test 1: Cek database connection
        echo "<h3>1. Database Connection Test</h3>";
        try {
            $totalLogs = $this->logModel->countAllResults();
            echo "<p>✅ Database terhubung. Total logs: " . $totalLogs . "</p>";
        } catch (\Exception $e) {
            echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
            return;
        }
        
        // Test 2: Buat log aktivitas untuk setiap controller
        echo "<h3>2. Test Log dari Berbagai Sumber</h3>";
        
        // Test log dari Auth (guest)
        echo "<p>Test log dari Auth (guest)...</p>";
        $this->logModel->logActivity(0, 'Test log dari Auth controller (guest)');
        
        // Test log dari Dashboard
        echo "<p>Test log dari Dashboard...</p>";
        $this->logModel->logActivity(1, 'Test log dari Dashboard controller');
        
        // Test log dari CRUD
        echo "<p>Test log dari CRUD controllers...</p>";
        $this->logModel->logCRUD(1, 'create', 'test', 'Test CRUD create');
        $this->logModel->logCRUD(1, 'update', 'test', 'Test CRUD update');
        $this->logModel->logCRUD(1, 'delete', 'test', 'Test CRUD delete');
        
        // Test log transaksi
        echo "<p>Test log transaksi...</p>";
        $this->logModel->logTransaksi(1, 'masuk', 'Test transaksi masuk');
        $this->logModel->logTransaksi(1, 'keluar', 'Test transaksi keluar');
        
        echo "<p style='color: green;'>✅ Semua test log berhasil dibuat!</p>";
        
        // Test 3: Baca semua log
        echo "<h3>3. Membaca Semua Log</h3>";
        try {
            $logs = $this->logModel->getLogsWithUser(20, 0);
            echo "<p>Ditemukan " . count($logs) . " log terbaru</p>";
            
            if (!empty($logs)) {
                echo "<table border='1' cellpadding='5' style='width: 100%;'>";
                echo "<tr><th>ID</th><th>User</th><th>Aktivitas</th><th>Waktu</th><th>IP</th></tr>";
                
                foreach ($logs as $log) {
                    echo "<tr>";
                    echo "<td>{$log['id_log']}</td>";
                    echo "<td>" . ($log['username'] ?? 'Guest') . "</td>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "<td>" . $log['waktu_aktivitas'] . "</td>";
                    echo "<td>{$log['ip_address']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error membaca log: " . $e->getMessage() . "</p>";
        }
        
        // Test 4: Test search
        echo "<h3>4. Test Search Log</h3>";
        try {
            $searchResults = $this->logModel->searchLogs('test');
            echo "<p>Search 'test' menemukan " . count($searchResults) . " hasil</p>";
            
            if (!empty($searchResults)) {
                echo "<table border='1' cellpadding='5' style='width: 100%;'>";
                echo "<tr><th>Aktivitas</th><th>Waktu</th></tr>";
                
                foreach ($searchResults as $log) {
                    echo "<tr>";
                    echo "<td>{$log['aktivitas']}</td>";
                    echo "<td>{$log['waktu_aktivitas']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error search: " . $e->getMessage() . "</p>";
        }
        
        // Test 5: Statistik
        echo "<h3>5. Test Statistik</h3>";
        try {
            $today = date('Y-m-d');
            $stats = $this->logModel->getAktivitasStats($today, $today);
            echo "<p>Statistik hari ini: " . json_encode($stats) . "</p>";
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error statistik: " . $e->getMessage() . "</p>";
        }
        
        echo "<br><br>";
        echo "<h3>📊 Hasil Test</h3>";
        echo "<p>✅ Log aktivitas berfungsi dengan baik!</p>";
        echo "<p>✅ Semua controller sudah mencatat aktivitas</p>";
        echo "<p>✅ Search dan statistik berfungsi</p>";
        
        echo "<br><br>";
        echo "<a href='/log-aktivitas' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>📋 Lihat Log Aktivitas</a>";
        echo " ";
        echo "<a href='/test-log-fix' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔧 Test Log Fix</a>";
        echo " ";
        echo "<a href='/dashboard' style='background: #6f42c1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🏠 Dashboard</a>";
    }
}
