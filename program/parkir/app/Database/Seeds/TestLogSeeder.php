<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestLogSeeder extends Seeder
{
    public function run()
    {
        $logModel = new \App\Models\LogAktivitas();
        $userModel = new \App\Models\User();
        
        // Cek user yang ada
        $users = $userModel->findAll();
        $userIds = array_column($users, 'id_user');
        
        if (empty($userIds)) {
            echo "<p style='color: red;'>❌ Tidak ada user di database. Jalankan UserSeeder terlebih dahulu!</p>";
            return;
        }
        
        // Test log aktivitas untuk user yang ada
        $testLogs = [
            [
                'id_user' => $userIds[0], // User pertama yang ada
                'aktivitas' => 'Test login user',
                'waktu_aktivitas' => date('Y-m-d H:i:s'),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0 Safari/537.36'
            ],
            [
                'id_user' => null, // Guest (NULL)
                'aktivitas' => 'Test akses welcome page (guest)',
                'waktu_aktivitas' => date('Y-m-d H:i:s'),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0 Safari/537.36'
            ]
        ];
        
        // Tambahkan log untuk user kedua jika ada
        if (count($userIds) >= 2) {
            $testLogs[] = [
                'id_user' => $userIds[1],
                'aktivitas' => 'Test login user kedua',
                'waktu_aktivitas' => date('Y-m-d H:i:s'),
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0 Safari/537.36'
            ];
        }
        
        foreach ($testLogs as $log) {
            $logModel->insert($log);
        }
        
        echo "<h2>📝 Test Log Aktivitas Seeder</h2>";
        echo "<p>Berhasil menambahkan " . count($testLogs) . " log aktivitas test</p>";
        echo "<p>✅ Seeder berhasil dijalankan!</p>";
        echo "<p>Users yang tersedia: " . json_encode($userIds) . "</p>";
        
        echo "<br><a href='/log-aktivitas'>Lihat Log Aktivitas</a>";
    }
}
