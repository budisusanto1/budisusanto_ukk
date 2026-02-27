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
                
                // UPDATE USER
                if (isset($_POST['update_user'])) {
                    $userId = $_POST['user_id'] ?? 0;
                    $nama_lengkap = $_POST['update_nama_lengkap'] ?? '';
                    $role = $_POST['update_role'] ?? 'petugas';
                    
                    echo "<h4>Updating User ID: $userId</h4>";
                    
                    $stmt = $mysqli->prepare("UPDATE tb_user SET nama_lengkap = ?, role = ? WHERE id_user = ?");
                    $stmt->bind_param('ssi', $nama_lengkap, $role, $userId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ User updated successfully!</p>";
                    } else {
                        echo "<p class='error'>❌ Update failed: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                }
                
                // DELETE USER
                if (isset($_POST['delete_user'])) {
                    $userId = $_POST['delete_user_id'] ?? 0;
                    
                    echo "<h4>Deleting User ID: $userId</h4>";
                    
                    $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
                    $stmt->bind_param('i', $userId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ User deleted successfully!</p>";
                    } else {
                        echo "<p class='error'>❌ Delete failed: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
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
                
                // UPDATE TARIF
                if (isset($_POST['update_tarif'])) {
                    $tarifId = $_POST['tarif_id'] ?? 0;
                    $tarif_per_jam = $_POST['update_tarif_per_jam'] ?? 0;
                    
                    echo "<h4>Updating Tarif ID: $tarifId</h4>";
                    
                    $stmt = $mysqli->prepare("UPDATE tb_tarif SET tarif_per_jam = ? WHERE id_tarif = ?");
                    $stmt->bind_param('ii', $tarif_per_jam, $tarifId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ Tarif updated successfully!</p>";
                    } else {
                        echo "<p class='error'>❌ Update failed: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                }
                
                // DELETE TARIF
                if (isset($_POST['delete_tarif'])) {
                    $tarifId = $_POST['delete_tarif_id'] ?? 0;
                    
                    echo "<h4>Deleting Tarif ID: $tarifId</h4>";
                    
                    $stmt = $mysqli->prepare("DELETE FROM tb_tarif WHERE id_tarif = ?");
                    $stmt->bind_param('i', $tarifId);
                    
                    if ($stmt->execute()) {
                        echo "<p class='success'>✅ Tarif deleted successfully!</p>";
                    } else {
                        echo "<p class='error'>❌ Delete failed: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                }
                
                echo "</div>";
            }
            
            // Show current data
            echo "<div class='test-section'>";
            echo "<h3>📊 Current Data</h3>";
            
            // Show Users
            echo "<h4>Current Users:</h4>";
            $result = $mysqli->query("SELECT id_user, username, nama_lengkap, role FROM tb_user ORDER BY id_user");
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Nama Lengkap</th><th>Role</th><th>Action</th></tr>";
            while ($user = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$user['id_user']}</td>";
                echo "<td>{$user['username']}</td>";
                echo "<td>{$user['nama_lengkap']}</td>";
                echo "<td>{$user['role']}</td>";
                echo "<td>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='delete_user_id' value='{$user['id_user']}'>
                        <button type='submit' name='delete_user' class='btn btn-danger' onclick='return confirm(\"Hapus user ini?\")'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Show Tarifs
            echo "<h4>Current Tarifs:</h4>";
            $result = $mysqli->query("SELECT id_tarif, jenis_kendaraan, tarif_per_jam FROM tb_tarif ORDER BY jenis_kendaraan");
            echo "<table>";
            echo "<tr><th>ID</th><th>Jenis Kendaraan</th><th>Tarif per Jam</th><th>Action</th></tr>";
            while ($tarif = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$tarif['id_tarif']}</td>";
                echo "<td>{$tarif['jenis_kendaraan']}</td>";
                echo "<td>Rp " . number_format($tarif['tarif_per_jam']) . "</td>";
                echo "<td>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='delete_tarif_id' value='{$tarif['id_tarif']}'>
                        <button type='submit' name='delete_tarif' class='btn btn-danger' onclick='return confirm(\"Hapus tarif ini?\")'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "</div>";
            
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
            
            <hr>
            
            <h4>Update User:</h4>
            <div class="form-group">
                <label>User ID:</label>
                <input type="number" name="user_id" required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap Baru:</label>
                <input type="text" name="update_nama_lengkap" maxlength="255">
            </div>
            <div class="form-group">
                <label>Role Baru:</label>
                <select name="update_role">
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>
            <button type="submit" name="update_user" class="btn">Update User</button>
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
            
            <hr>
            
            <h4>Update Tarif:</h4>
            <div class="form-group">
                <label>Tarif ID:</label>
                <input type="number" name="tarif_id" required>
            </div>
            <div class="form-group">
                <label>Tarif Baru per Jam:</label>
                <input type="number" name="update_tarif_per_jam" required min="0" step="0.01">
            </div>
            <button type="submit" name="update_tarif" class="btn">Update Tarif</button>
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
    
    <div class="test-section">
        <h3>📝 Testing Instructions</h3>
        <ol>
            <li><strong>Create User:</strong> Isi form dan klik "Create User"</li>
            <li><strong>Update User:</strong> Masukkan ID user yang ada dan data baru</li>
            <li><strong>Delete User:</strong> Klik tombol "Delete" di tabel user</li>
            <li><strong>Create Tarif:</strong> Pilih jenis kendaraan dan masukkan tarif</li>
            <li><strong>Update Tarif:</strong> Masukkan ID tarif dan tarif baru</li>
            <li><strong>Delete Tarif:</strong> Klik tombol "Delete" di tabel tarif</li>
        </ol>
    </div>
</body>
</html>
