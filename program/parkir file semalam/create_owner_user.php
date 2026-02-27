<?php
// Script untuk membuat user dengan role owner
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
    
    // Data user owner
    $owner_user = [
        'username' => 'owner',
        'nama_lengkap' => 'BCS Mall Owner',
        'password' => password_hash('owner123', PASSWORD_DEFAULT),
        'role' => 'owner',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    
    // Cek apakah user owner sudah ada
    $cek_query = "SELECT * FROM tb_user WHERE username = 'owner'";
    $result = mysqli_query($koneksi, $cek_query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "ℹ️ User 'owner' sudah ada. Mengupdate data...\n";
        
        // Update user owner
        $sql = "UPDATE tb_user SET nama_lengkap = ?, password = ?, role = ?, updated_at = ? WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", 
            $owner_user['nama_lengkap'],
            $owner_user['password'],
            $owner_user['role'],
            $owner_user['updated_at'],
            $owner_user['username']
        );
        mysqli_stmt_execute($stmt);
        echo "✅ User 'owner' berhasil diupdate!\n";
    } else {
        echo "ℹ️ Membuat user 'owner' baru...\n";
        
        // Insert user owner
        $sql = "INSERT INTO tb_user (username, nama_lengkap, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $owner_user['username'],
            $owner_user['nama_lengkap'],
            $owner_user['password'],
            $owner_user['role'],
            $owner_user['created_at'],
            $owner_user['updated_at']
        );
        mysqli_stmt_execute($stmt);
        echo "✅ User 'owner' berhasil dibuat!\n";
    }
    
    echo "\n🎉 Data Owner Berhasil Disiapkan!\n";
    echo "📋 Login Information:\n";
    echo "   Username: owner\n";
    echo "   Password: owner123\n";
    echo "   Role: owner\n";
    echo "\n🔑 Fitur Owner:\n";
    echo "   - Dashboard khusus owner\n";
    echo "   - Rekap Transaksi\n";
    echo "   - Laporan Pendapatan\n";
    echo "   - Statistik Parkir\n";
    echo "\n📝 Sekarang bisa login dengan role owner!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} finally {
    if (isset($koneksi)) {
        mysqli_close($koneksi);
    }
}
?>
