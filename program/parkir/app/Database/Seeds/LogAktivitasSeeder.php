<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LogAktivitasSeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi data default
        $this->call('UserSeeder');
        
        // Inisialisasi tarif default
        $tarifModel = new \App\Models\Tarif();
        $tarifModel->initializeDefaultTarif();
        
        // Inisialisasi area default
        $areaModel = new \App\Models\AreaParkir();
        $areaModel->initializeDefaultAreas();
        
        echo "Data default berhasil diinisialisasi!\n";
    }
}
