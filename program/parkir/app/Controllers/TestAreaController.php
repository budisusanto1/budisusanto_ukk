<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;

class TestAreaController extends BaseController
{
    protected $areaModel;
    protected $logModel;

    public function __construct()
    {
        $this->areaModel = new AreaParkir();
        $this->logModel = new LogAktivitas();
    }

    public function index()
    {
        echo "<h2>Test CRUD Area Parkir</h2>";
        
        // Test 1: Create Area
        echo "<h3>1. Test Create Area</h3>";
        $testData = [
            'nama_area' => 'Test Area ' . date('H:i:s'),
            'kapasitas' => 50,
            'terisi' => 0
        ];
        
        echo "<p>Data yang akan disimpan: " . json_encode($testData) . "</p>";
        
        if ($this->areaModel->save($testData)) {
            $insertId = $this->areaModel->getInsertID();
            echo "<p style='color: green;'>✅ Area berhasil dibuat dengan ID: $insertId</p>";
        } else {
            echo "<p style='color: red;'>❌ Gagal membuat area: " . json_encode($this->areaModel->errors()) . "</p>";
        }
        
        // Test 2: Read Area
        echo "<h3>2. Test Read Area</h3>";
        $areas = $this->areaModel->findAll();
        echo "<p>Total area: " . count($areas) . "</p>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nama Area</th><th>Kapasitas</th><th>Terisi</th></tr>";
        foreach ($areas as $area) {
            echo "<tr>";
            echo "<td>{$area['id_area']}</td>";
            echo "<td>{$area['nama_area']}</td>";
            echo "<td>{$area['kapasitas']}</td>";
            echo "<td>{$area['terisi']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test 3: Update Area
        echo "<h3>3. Test Update Area</h3>";
        if (!empty($areas)) {
            $firstArea = $areas[0];
            $updateData = [
                'kapasitas' => 100,
                'terisi' => 25
            ];
            
            echo "<p>Update area ID {$firstArea['id_area']} dengan: " . json_encode($updateData) . "</p>";
            
            if ($this->areaModel->update($firstArea['id_area'], $updateData)) {
                echo "<p style='color: green;'>✅ Area berhasil diupdate</p>";
            } else {
                echo "<p style='color: red;'>❌ Gagal update area: " . json_encode($this->areaModel->errors()) . "</p>";
            }
        }
        
        // Test 4: Delete Area
        echo "<h3>4. Test Delete Area</h3>";
        if (!empty($areas)) {
            $lastArea = end($areas);
            echo "<p>Hapus area ID {$lastArea['id_area']} ({$lastArea['nama_area']})</p>";
            
            if ($this->areaModel->delete($lastArea['id_area'])) {
                echo "<p style='color: green;'>✅ Area berhasil dihapus</p>";
            } else {
                echo "<p style='color: red;'>❌ Gagal hapus area: " . json_encode($this->areaModel->errors()) . "</p>";
            }
        }
        
        // Test 5: Custom Methods
        echo "<h3>5. Test Custom Methods</h3>";
        
        $stats = $this->areaModel->getStatistikArea();
        echo "<p>Statistik Area: " . json_encode($stats) . "</p>";
        
        $tersedia = $this->areaModel->getAreaTersedia();
        echo "<p>Area Tersedia: " . count($tersedia) . "</p>";
        
        echo "<br><br>";
        echo "<a href='/area'>Kembali ke halaman Area</a>";
        echo " | ";
        echo "<a href='/test-log'>Test Log Aktivitas</a>";
    }
}
