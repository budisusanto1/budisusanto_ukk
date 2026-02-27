<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\User();
        
        // Cek apakah admin sudah ada
        $adminExists = $userModel->where('username', 'admin')->first();
        
        if (!$adminExists) {
            // Buat user admin default
            $data = [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Administrator',
                'role' => 'admin'
            ];
            
            $userModel->insert($data);
            echo "User admin default berhasil dibuat!\n";
        } else {
            echo "User admin sudah ada!\n";
        }
        
        // Cek apakah superadmin sudah ada
        $superadminExists = $userModel->where('username', 'superadmin')->first();
        
        if (!$superadminExists) {
            // Buat user superadmin default
            $data = [
                'username' => 'superadmin',
                'password' => password_hash('superadmin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Super Administrator',
                'role' => 'superadmin'
            ];
            
            $userModel->insert($data);
            echo "User superadmin default berhasil dibuat!\n";
        } else {
            echo "User superadmin sudah ada!\n";
        }
    }
}
