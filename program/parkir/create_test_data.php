<?php
// Script untuk membuat data testing transaksi
$db = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'parkir',
    'DBDriver' => 'MySQLi'
];

try {
    $koneksi = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }
    
    echo "✅ Koneksi database berhasil!\n\n";
    // Data kendaraan testing
    $kendaraan = [
        [
            'plat_nomor' => 'B1234ABC',
            'jenis_kendaraan' => 'mobil',
            'warna' => 'Hitam',
            'pemilik' => 'Ahmad Yani',
            'id_user' => 4 // ID user petugas
        ],
        [
            'plat_nomor' => 'C5678DEF',
            'jenis_kendaraan' => 'motor',
            'warna' => 'Merah',
            'pemilik' => 'Siti Nurhaliza',
            'id_user' => 4
        ]
    ];

    // Insert data kendaraan
    foreach ($kendaraan as $kendaraan) {
        $plat_nomor = $kendaraan['plat_nomor'];
        $jenis_kendaraan = $kendaraan['jenis_kendaraan'];
        $warna = $kendaraan['warna'];
        $pemilik = $kendaraan['pemilik'];
        $id_user = $kendaraan['id_user'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, warna, pemilik, id_user, created_at, updated_at) VALUES ('$plat_nomor', '$jenis_kendaraan', '$warna', '$pemilik', $id_user, '$created_at', '$updated_at')";
        mysqli_query($koneksi, $sql);
        echo "✅ Kendaraan $plat_nomor berhasil ditambahkan\n";
    }

    // Data transaksi testing
    $transaksi = [
        [
            'id_kendaraan' => 1, // Mobil B1234ABC
            'waktu_masuk' => date('Y-m-d H:i:s', strtotime('-2 hours')), // 2 jam lalu
            'id_tarif' => 2, // Mobil tarif
            'status' => 'masuk',
            'id_user' => 4,
            'id_area' => 1
        ],
        [
            'id_kendaraan' => 2, // Motor C5678DEF
            'waktu_masuk' => date('Y-m-d H:i:s', strtotime('-1 hours')), // 1 jam lalu
            'id_tarif' => 1, // Motor tarif
            'status' => 'keluar', // Sudah keluar
            'waktu_keluar' => date('Y-m-d H:i:s', strtotime('-30 minutes')), // 30 menit lalu
            'durasi_jam' => 2, // 2 jam (dibulatkan)
            'biaya_total' => 6000, // 2 jam x Rp 3.000
            'id_user' => 4,
            'id_area' => 1
        ]
    ];

    // Insert data transaksi
    foreach ($transaksi as $t) {
        $id_kendaraan = $t['id_kendaraan'];
        $waktu_masuk = $t['waktu_masuk'];
        $id_tarif = $t['id_tarif'];
        $status = $t['status'];
        $id_user = $t['id_user'];
        $id_area = $t['id_area'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO tb_transaksi (id_kendaraan, waktu_masuk, id_tarif, status, id_user, id_area, created_at, updated_at) VALUES ($id_kendaraan, '$waktu_masuk', $id_tarif, '$status', $id_user, $id_area, '$created_at', '$updated_at')";
        mysqli_query($koneksi, $sql);
        echo "✅ Transaksi kendaraan $id_kendaraan berhasil ditambahkan\n";
    }

    // Data area parkir testing
    $areas = [
        ['nama_area' => 'Area A', 'kapasitas' => 50, 'terisi' => 25],
        ['nama_area' => 'Area B', 'kapasitas' => 30, 'terisi' => 15]
    ];

    // Insert data area
    foreach ($areas as $area) {
        $sql = "INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sii", 
            $area['nama_area'], 
            $area['kapasitas'], 
            $area['terisi']
        );
        mysqli_stmt_execute($stmt);
        echo "✅ Area {$area['nama_area']} berhasil ditambahkan\n";
    }

    echo "\n🎉 Data testing berhasil dibuat!\n";
    echo "📊 Total kendaraan: " . count($kendaraan) . "\n";
    echo "🚗 Total transaksi: " . count($transaksi) . "\n";
    echo "🅿️ Total area: " . count($areas) . "\n";
    echo "\n📝 Sekarang bisa testing transaksi masuk/keluar!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} finally {
    if (isset($koneksi)) {
        mysqli_close($koneksi);
    }
}
