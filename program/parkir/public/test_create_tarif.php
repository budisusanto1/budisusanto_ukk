<?php
// Test create tarif yang sederhana
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Create Tarif</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .info { color: blue; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 20px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn:hover { background: #0056b3; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 300px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🧪 Test Create Tarif</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $mysqli = new mysqli('localhost', 'root', '', 'parkir');
            
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            echo "<div class='test-section'>";
            echo "<h2>📊 Form Submission Analysis</h2>";
            
            // Get form data
            $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
            $tarif_per_jam = $_POST['tarif_per_jam'] ?? 0;
            
            echo "<h3>📝 Submitted Data:</h3>";
            echo "<table>";
            echo "<tr><th>Field</th><th>Value</th><th>Empty?</th><th>Valid?</th></tr>";
            echo "<tr><td>jenis_kendaraan</td><td>$jenis_kendaraan</td><td>" . (empty($jenis_kendaraan) ? 'YES' : 'NO') . "</td><td>" . (in_array($jenis_kendaraan, ['mobil', 'motor', 'truk', 'bus', 'lainnya']) ? 'YES' : 'NO') . "</td></tr>";
            echo "<tr><td>tarif_per_jam</td><td>Rp " . number_format($tarif_per_jam) . "</td><td>" . (empty($tarif_per_jam) ? 'YES' : 'NO') . "</td><td>" . (is_numeric($tarif_per_jam) && $tarif_per_jam >= 0 ? 'YES' : 'NO') . "</td></tr>";
            echo "</table>";
            
            // Validation
            echo "<h3>✅ Validation Checks:</h3>";
            $errors = [];
            
            if (empty($jenis_kendaraan)) {
                $errors[] = "Jenis kendaraan harus dipilih";
            }
            
            if (!in_array($jenis_kendaraan, ['mobil', 'motor', 'truk', 'bus', 'lainnya'])) {
                $errors[] = "Jenis kendaraan tidak valid";
            }
            
            if (!is_numeric($tarif_per_jam) || $tarif_per_jam < 0) {
                $errors[] = "Tarif harus angka positif";
            }
            
            // Check if tarif already exists
            $result = $mysqli->query("SELECT COUNT(*) as count FROM tb_tarif WHERE jenis_kendaraan = '$jenis_kendaraan'");
            $count = $result->fetch_assoc()['count'];
            if ($count > 0) {
                $errors[] = "Tarif untuk $jenis_kendaraan sudah ada!";
            }
            
            if (empty($errors)) {
                echo "<p class='success'>✅ All validation checks passed</p>";
                
                // Test database insert
                echo "<h3>💾 Database Insert Test:</h3>";
                
                $stmt = $mysqli->prepare("INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES (?, ?)");
                $stmt->bind_param('si', $jenis_kendaraan, $tarif_per_jam);
                
                if ($stmt->execute()) {
                    $tarifId = $mysqli->insert_id;
                    echo "<p class='success'>✅ SUCCESS: Tarif berhasil dibuat! ID: $tarifId</p>";
                    
                    // Verify insert
                    $result = $mysqli->query("SELECT * FROM tb_tarif WHERE id_tarif = $tarifId");
                    $tarif = $result->fetch_assoc();
                    echo "<p class='success'>✅ VERIFICATION: Tarif {$tarif['jenis_kendaraan']} Rp " . number_format($tarif['tarif_per_jam']) . " berhasil disimpan</p>";
                    
                    // Clean up test data
                    $stmt = $mysqli->prepare("DELETE FROM tb_tarif WHERE id_tarif = ?");
                    $stmt->bind_param('i', $tarifId);
                    $stmt->execute();
                    $stmt->close();
                    echo "<p class='info'>🧹 Test data cleaned up</p>";
                } else {
                    echo "<p class='error'>❌ FAILED: " . $stmt->error . "</p>";
                    echo "<p class='error'>❌ SQLSTATE: " . $stmt->sqlstate . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p class='error'>❌ Validation errors:</p>";
                echo "<ul>";
                foreach ($errors as $error) {
                    echo "<li class='error'>$error</li>";
                }
                echo "</ul>";
            }
            
            echo "</div>";
            
            $mysqli->close();
            
        } catch (Exception $e) {
            echo "<h2 class='error'>❌ Exception: " . $e->getMessage() . "</h2>";
        }
    }
    ?>
    
    <div class="test-section">
        <h3>🧪 Test Create Tarif Form</h3>
        <form method="post">
            <div class="form-group">
                <label for="jenis_kendaraan">Jenis Kendaraan:</label>
                <select id="jenis_kendaraan" name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis</option>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                    <option value="truk">Truk</option>
                    <option value="bus">Bus</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tarif_per_jam">Tarif per Jam:</label>
                <input type="number" id="tarif_per_jam" name="tarif_per_jam" required min="0" step="0.01" placeholder="Contoh: 5000">
                <small>Harus angka positif</small>
            </div>
            
            <button type="submit" class="btn btn-success">Create Tarif</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>📋 Test Scenarios:</h3>
        <ol>
            <li><strong>Test 1:</strong> Mobil - Rp 5000 (seharusnya berhasil)</li>
            <li><strong>Test 2:</strong> Motor - Rp 2000 (seharusnya berhasil)</li>
            <li><strong>Test 3:</strong> Truk - Rp 10000 (seharusnya berhasil)</li>
            <li><strong>Test 4:</strong> Bus - Rp 15000 (seharusnya berhasil)</li>
            <li><strong>Test 5:</strong> Duplikasi mobil (seharusnya gagal)</li>
            <li><strong>Test 6:</strong> Jenis tidak valid (seharusnya gagal)</li>
            <li><strong>Test 7:</strong> Tarif negatif (seharusnya gagal)</li>
        </ol>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Links</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/tarif" class="btn">Tarif Management</a> |
            <a href="/users" class="btn">User Management</a>
        </p>
    </div>
    
    <div class="test-section">
        <h3>📝 Expected Results:</h3>
        <ul>
            <li>✅ <strong>Validation:</strong> Semua field valid</li>
            <li>✅ <strong>Database:</strong> Tarif berhasil disimpan</li>
            <li>✅ <strong>Duplikasi:</strong> Dicegah untuk tarif yang sama</li>
            <li>✅ <strong>Update:</strong> Bisa update tarif yang ada</li>
        </ul>
    </div>
</body>
</html>
