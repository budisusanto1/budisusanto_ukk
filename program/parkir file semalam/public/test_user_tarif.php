<?php
// Test khusus User dan Tarif CRUD
?>
<!DOCTYPE html>
<html>
<head>
    <title>User & Tarif CRUD Test</title>
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
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 300px; }
    </style>
</head>
<body>
    <h1>🧪 User & Tarif CRUD Test</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $mysqli = new mysqli('localhost', 'root', '', 'parkir');
            
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            echo "<h2 class='success'>✅ Database Connected</h2>";
            
            // Test User CRUD
            if (isset($_POST['test_user_crud'])) {
                echo "<div class='test-section'>";
                echo "<h3>👥 User CRUD Operations</h3>";
                
                // CREATE USER
                if (isset($_POST['create_user'])) {
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
                    $role = $_POST['role'] ?? 'petugas';
                    
                    echo "<h4>Creating User...</h4>";
                    echo "Username: $username<br>";
                    echo "Password: " . (empty($password) ? 'EMPTY' : 'FILLED') . "<br>";
                    echo "Nama Lengkap: $nama_lengkap<br>";
                    echo "Role: $role<br>";
                    
                    // Validation
                    $errors = [];
                    if (strlen($username) < 3) $errors[] = "Username minimal 3 karakter";
                    if (strlen($password) < 6) $errors[] = "Password minimal 6 karakter";
                    if (!in_array($role, ['admin', 'superadmin', 'petugas'])) $errors[] = "Role tidak valid";
                    
                    if (empty($errors)) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param('ssss', $username, $hashed_password, $nama_lengkap, $role);
                        
                        if ($stmt->execute()) {
                            $userId = $mysqli->insert_id;
                            echo "<p class='success'>✅ User created successfully! ID: $userId</p>";
                        } else {
                            echo "<p class='error'>❌ Create failed: " . $stmt->error . "</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "<p class='error'>❌ Validation errors: " . implode(', ', $errors) . "</p>";
                    }
                }
                
                echo "</div>";
            }
            
            // Test Tarif CRUD
            if (isset($_POST['test_tarif_crud'])) {
                echo "<div class='test-section'>";
                echo "<h3>💰 Tarif CRUD Operations</h3>";
                
                // CREATE TARIF
                if (isset($_POST['create_tarif'])) {
                    $jenis_kendaraan = $_POST['jenis_kendaraan'] ?? '';
                    $tarif_per_jam = $_POST['tarif_per_jam'] ?? 0;
                    
                    echo "<h4>Creating Tarif...</h4>";
                    echo "Jenis Kendaraan: $jenis_kendaraan<br>";
                    echo "Tarif per Jam: $tarif_per_jam<br>";
                    
                    // Validation
                    $errors = [];
                    if (!in_array($jenis_kendaraan, ['mobil', 'motor', 'truk', 'bus', 'lainnya'])) {
                        $errors[] = "Jenis kendaraan tidak valid";
                    }
                    if (!is_numeric($tarif_per_jam) || $tarif_per_jam < 0) {
                        $errors[] = "Tarif harus angka positif";
                    }
                    
                    if (empty($errors)) {
                        // Check if already exists
                        $result = $mysqli->query("SELECT COUNT(*) as count FROM tb_tarif WHERE jenis_kendaraan = '$jenis_kendaraan'");
                        $count = $result->fetch_assoc()['count'];
                        
                        if ($count > 0) {
                            echo "<p class='error'>❌ Tarif untuk $jenis_kendaraan sudah ada!</p>";
                        } else {
                            $stmt = $mysqli->prepare("INSERT INTO tb_tarif (jenis_kendaraan, tarif_per_jam) VALUES (?, ?)");
                            $stmt->bind_param('si', $jenis_kendaraan, $tarif_per_jam);
                            
                            if ($stmt->execute()) {
                                $tarifId = $mysqli->insert_id;
                                echo "<p class='success'>✅ Tarif created successfully! ID: $tarifId</p>";
                            } else {
                                echo "<p class='error'>❌ Create failed: " . $stmt->error . "</p>";
                            }
                            $stmt->close();
                        }
                    } else {
                        echo "<p class='error'>❌ Validation errors: " . implode(', ', $errors) . "</p>";
                    }
                }
                
                echo "</div>";
            }
            
            $mysqli->close();
            
        } catch (Exception $e) {
            echo "<h2 class='error'>❌ Error: " . $e->getMessage() . "</h2>";
        }
    }
    ?>
    
    <!-- User CRUD Form -->
    <div class="test-section">
        <h3>👥 User CRUD Form</h3>
        <form method="post">
            <input type="hidden" name="test_user_crud" value="1">
            
            <h4>Create New User:</h4>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required minlength="3" maxlength="100">
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required minlength="6">
            </div>
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" maxlength="255">
            </div>
            <div class="form-group">
                <label>Role:</label>
                <select name="role">
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>
            <button type="submit" name="create_user" class="btn btn-success">Create User</button>
        </form>
    </div>
    
    <!-- Tarif CRUD Form -->
    <div class="test-section">
        <h3>💰 Tarif CRUD Form</h3>
        <form method="post">
            <input type="hidden" name="test_tarif_crud" value="1">
            
            <h4>Create New Tarif:</h4>
            <div class="form-group">
                <label>Jenis Kendaraan:</label>
                <select name="jenis_kendaraan" required>
                    <option value="">Pilih Jenis</option>
                    <option value="mobil">Mobil</option>
                    <option value="motor">Motor</option>
                    <option value="truk">Truk</option>
                    <option value="bus">Bus</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tarif per Jam:</label>
                <input type="number" name="tarif_per_jam" required min="0" step="0.01">
            </div>
            <button type="submit" name="create_tarif" class="btn btn-success">Create Tarif</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Access</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/users" class="btn">User Management</a> |
            <a href="/tarif" class="btn">Tarif Management</a> |
            <a href="/log-aktivitas" class="btn">Log Aktivitas</a>
        </p>
    </div>
</body>
</html>
