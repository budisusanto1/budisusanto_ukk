<?php
// Test semua CRUD operations untuk admin dan superadmin
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Operations Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        .info { color: blue; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 20px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🧪 CRUD Operations Test - Admin & Superadmin</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $mysqli = new mysqli('localhost', 'root', '', 'parkir');
            
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            echo "<h2 class='success'>✅ Database Connected</h2>";
            
            // Test 1: User CRUD
            echo "<div class='test-section'>";
            echo "<h3>👥 User CRUD Test</h3>";
            
            // Create User Test
            if (isset($_POST['test_user_create'])) {
                $username = 'test_user_' . time();
                $password = password_hash('123456', PASSWORD_DEFAULT);
                $nama_lengkap = 'Test User ' . time();
                $role = 'petugas';
                
                $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('ssss', $username, $password, $nama_lengkap, $role);
                
                if ($stmt->execute()) {
                    $userId = $mysqli->insert_id;
                    echo "<p class='success'>✅ User created: $username (ID: $userId)</p>";
                    
                    // Read User Test
                    $result = $mysqli->query("SELECT * FROM tb_user WHERE id_user = $userId");
                    $user = $result->fetch_assoc();
                    echo "<p class='success'>✅ User read: {$user['username']} - {$user['nama_lengkap']}</p>";
                    
                    // Update User Test
                    $new_nama = 'Updated User ' . time();
                    $stmt = $mysqli->prepare("UPDATE tb_user SET nama_lengkap = ? WHERE id_user = ?");
                    $stmt->bind_param('si', $new_nama, $userId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ User updated: $new_nama</p>";
                        
                        // Delete User Test
                        $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
                        $stmt->bind_param('i', $userId);
                        
                        if ($stmt->execute()) {
                            echo "<p class='success'>✅ User deleted: $username</p>";
                        } else {
                            echo "<p class='error'>❌ User delete failed</p>";
                        }
                    } else {
                        echo "<p class='error'>❌ User update failed</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p class='error'>❌ User create failed</p>";
                }
            }
            
            echo "</div>";
            
            // Test 2: Kendaraan CRUD
            echo "<div class='test-section'>";
            echo "<h3>🚗 Kendaraan CRUD Test</h3>";
            
            if (isset($_POST['test_kendaraan_create'])) {
                $plat_nomor = 'TEST-' . time();
                $jenis_kendaraan = 'mobil';
                $warna = 'Merah';
                $pemilik = 'Test Owner';
                $id_user = 1; // Admin user
                
                $stmt = $mysqli->prepare("INSERT INTO tb_kendaraan (plat_nomor, jenis_kendaraan, warna, pemilik, id_user) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('ssssi', $plat_nomor, $jenis_kendaraan, $warna, $pemilik, $id_user);
                
                if ($stmt->execute()) {
                    $kendaraanId = $mysqli->insert_id;
                    echo "<p class='success'>✅ Kendaraan created: $plat_nomor (ID: $kendaraanId)</p>";
                    
                    // Read Kendaraan Test
                    $result = $mysqli->query("SELECT * FROM tb_kendaraan WHERE id_kendaraan = $kendaraanId");
                    $kendaraan = $result->fetch_assoc();
                    echo "<p class='success'>✅ Kendaraan read: {$kendaraan['plat_nomor']} - {$kendaraan['jenis_kendaraan']}</p>";
                    
                    // Update Kendaraan Test
                    $new_warna = 'Biru';
                    $stmt = $mysqli->prepare("UPDATE tb_kendaraan SET warna = ? WHERE id_kendaraan = ?");
                    $stmt->bind_param('si', $new_warna, $kendaraanId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ Kendaraan updated: $new_warna</p>";
                        
                        // Delete Kendaraan Test
                        $stmt = $mysqli->prepare("DELETE FROM tb_kendaraan WHERE id_kendaraan = ?");
                        $stmt->bind_param('i', $kendaraanId);
                        
                        if ($stmt->execute()) {
                            echo "<p class='success'>✅ Kendaraan deleted: $plat_nomor</p>";
                        } else {
                            echo "<p class='error'>❌ Kendaraan delete failed</p>";
                        }
                    } else {
                        echo "<p class='error'>❌ Kendaraan update failed</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p class='error'>❌ Kendaraan create failed</p>";
                }
            }
            
            echo "</div>";
            
            // Test 3: Tarif CRUD
            echo "<div class='test-section'>";
            echo "<h3>💰 Tarif CRUD Test</h3>";
            
            if (isset($_POST['test_tarif_create'])) {
                $jenis_kendaraan = 'test_mobil';
                $tarif_per_jam = 5000;
                
                $stmt = $mysqli->prepare("INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES (?, ?)");
                $stmt->bind_param('si', $jenis_kendaraan, $tarif_per_jam);
                
                if ($stmt->execute()) {
                    $tarifId = $mysqli->insert_id;
                    echo "<p class='success'>✅ Tarif created: $jenis_kendaraan (ID: $tarifId)</p>";
                    
                    // Read Tarif Test
                    $result = $mysqli->query("SELECT * FROM tb_tarif WHERE id_tarif = $tarifId");
                    $tarif = $result->fetch_assoc();
                    echo "<p class='success'>✅ Tarif read: {$tarif['jenis_kendaraan']} - Rp {$tarif['tarif_per_jam']}</p>";
                    
                    // Update Tarif Test
                    $new_tarif = 7500;
                    $stmt = $mysqli->prepare("UPDATE tb_tarif SET tarif_per_jam = ? WHERE id_tarif = ?");
                    $stmt->bind_param('ii', $new_tarif, $tarifId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ Tarif updated: Rp $new_tarif</p>";
                        
                        // Delete Tarif Test
                        $stmt = $mysqli->prepare("DELETE FROM tb_tarif WHERE id_tarif = ?");
                        $stmt->bind_param('i', $tarifId);
                        
                        if ($stmt->execute()) {
                            echo "<p class='success'>✅ Tarif deleted: $jenis_kendaraan</p>";
                        } else {
                            echo "<p class='error'>❌ Tarif delete failed</p>";
                        }
                    } else {
                        echo "<p class='error'>❌ Tarif update failed</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p class='error'>❌ Tarif create failed</p>";
                }
            }
            
            echo "</div>";
            
            // Test 4: Area Parkir CRUD
            echo "<div class='test-section'>";
            echo "<h3>🅿️ Area Parkir CRUD Test</h3>";
            
            if (isset($_POST['test_area_create'])) {
                $nama_area = 'Test Area ' . time();
                $kapasitas = 50;
                $terisi = 0;
                
                $stmt = $mysqli->prepare("INSERT INTO tb_area_parkir (nama_area, kapasitas, terisi) VALUES (?, ?, ?)");
                $stmt->bind_param('sii', $nama_area, $kapasitas, $terisi);
                
                if ($stmt->execute()) {
                    $areaId = $mysqli->insert_id;
                    echo "<p class='success'>✅ Area created: $nama_area (ID: $areaId)</p>";
                    
                    // Read Area Test
                    $result = $mysqli->query("SELECT * FROM tb_area_parkir WHERE id_area = $areaId");
                    $area = $result->fetch_assoc();
                    echo "<p class='success'>✅ Area read: {$area['nama_area']} - Kapasitas: {$area['kapasitas']}</p>";
                    
                    // Update Area Test
                    $new_kapasitas = 75;
                    $stmt = $mysqli->prepare("UPDATE tb_area_parkir SET kapasitas = ? WHERE id_area = ?");
                    $stmt->bind_param('ii', $new_kapasitas, $areaId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ Area updated: Kapasitas $new_kapasitas</p>";
                        
                        // Delete Area Test
                        $stmt = $mysqli->prepare("DELETE FROM tb_area_parkir WHERE id_area = ?");
                        $stmt->bind_param('i', $areaId);
                        
                        if ($stmt->execute()) {
                            echo "<p class='success'>✅ Area deleted: $nama_area</p>";
                        } else {
                            echo "<p class='error'>❌ Area delete failed</p>";
                        }
                    } else {
                        echo "<p class='error'>❌ Area update failed</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p class='error'>❌ Area create failed</p>";
                }
            }
            
            echo "</div>";
            
            $mysqli->close();
            
        } catch (Exception $e) {
            echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
        }
    }
    ?>
    
    <div class="test-section">
        <h3>🧪 Run CRUD Tests</h3>
        <form method="post">
            <button type="submit" name="test_user_create" class="btn btn-success">Test User CRUD</button>
            <button type="submit" name="test_kendaraan_create" class="btn btn-success">Test Kendaraan CRUD</button>
            <button type="submit" name="test_tarif_create" class="btn btn-success">Test Tarif CRUD</button>
            <button type="submit" name="test_area_create" class="btn btn-success">Test Area CRUD</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Access Links</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/users" class="btn">Users</a> |
            <a href="/kendaraan" class="btn">Kendaraan</a> |
            <a href="/tarif" class="btn">Tarif</a> |
            <a href="/area" class="btn">Area</a> |
            <a href="/log-aktivitas" class="btn">Log Aktivitas</a>
        </p>
    </div>
    
    <div class="test-section">
        <h3>📝 Manual Testing Steps</h3>
        <ol>
            <li>Login sebagai <strong>admin</strong> (dewasa1) atau <strong>superadmin</strong></li>
            <li>Coba <strong>Create</strong> data di setiap module</li>
            <li>Coba <strong>Read/View</strong> data yang sudah dibuat</li>
            <li>Coba <strong>Edit/Update</strong> data yang ada</li>
            <li>Coba <strong>Delete</strong> data</li>
            <li>Periksa <strong>Log Aktivitas</strong> untuk tracking</li>
        </ol>
    </div>
    
    <div class="test-section">
        <h3>⚠️ Common Issues & Solutions</h3>
        <ul>
            <li><strong>Create/Edit tidak berfungsi:</strong> Check validation rules di Models</li>
            <li><strong>Permission denied:</strong> Pastikan login sebagai admin/superadmin</li>
            <li><strong>Data tidak tersimpan:</strong> Check database connection dan foreign key</li>
            <li><strong>Form tidak muncul:</strong> Check view files di folder Views</li>
            <li><strong>Redirect error:</strong> Check routes configuration</li>
        </ul>
    </div>
    
    <hr>
    <p><a href="/">Back to Home</a></p>
</body>
</html>
