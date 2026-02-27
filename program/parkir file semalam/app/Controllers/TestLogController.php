<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;

class TestLogController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitas();
    }

    public function index()
    {
        // Test log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user') ?? 1,
            'Test log aktivitas dari TestLogController'
        );

        // Tampilkan log terbaru
        $logs = $this->logModel->getLogsWithUser(5, 0);
        
        echo "<h2>Test Log Aktivitas</h2>";
        echo "<p>Log berhasil ditambahkan! Berikut 5 log terbaru:</p>";
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>User</th><th>Aktivitas</th><th>Waktu</th><th>IP</th></tr>";
        
        foreach ($logs as $log) {
            echo "<tr>";
            echo "<td>{$log['id_log']}</td>";
            echo "<td>{$log['username']}</td>";
            echo "<td>{$log['aktivitas']}</td>";
            echo "<td>{$log['waktu_aktivitas']}</td>";
            echo "<td>{$log['ip_address']}</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        echo "<br><a href='/log-aktivitas'>Lihat semua log</a>";
    }
}
