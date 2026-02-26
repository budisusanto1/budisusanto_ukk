<?php
// Test khusus untuk edit user password
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Edit User Password</title>
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
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 300px; }
        .form-group input.error { border-color: red; border-width: 2px; }
        .validation-message { margin-top: 5px; font-size: 14px; }
        .validation-message.error { color: red; font-weight: bold; }
        .validation-message.warning { color: orange; font-weight: bold; }
        .validation-message.success { color: green; font-weight: bold; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .password-strength { margin-top: 5px; font-size: 12px; }
        .password-strength.weak { color: red; }
        .password-strength.medium { color: orange; }
        .password-strength.strong { color: green; }
    </style>
</head>
<body>
    <h1>🔧 Test Edit User Password</h1>
    
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
            $userId = $_POST['user_id'] ?? 0;
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $nama_lengkap = $_POST['nama_lengkap'] ?? '';
            $role = $_POST['role'] ?? 'petugas';
            
            echo "<h3>📝 Submitted Data:</h3>";
            echo "<table>";
            echo "<tr><th>Field</th><th>Value</th><th>Empty?</th><th>Length</th></tr>";
            echo "<tr><td>user_id</td><td>$userId</td><td>" . (empty($userId) ? 'YES' : 'NO') . "</td><td>" . strlen($userId) . "</td></tr>";
            echo "<tr><td>username</td><td>$username</td><td>" . (empty($username) ? 'YES' : 'NO') . "</td><td>" . strlen($username) . "</td></tr>";
            echo "<tr><td>password</td><td>" . (empty($password) ? 'EMPTY' : 'FILLED') . "</td><td>" . (empty($password) ? 'YES' : 'NO') . "</td><td>" . strlen($password) . "</td></tr>";
            echo "<tr><td>nama_lengkap</td><td>$nama_lengkap</td><td>" . (empty($nama_lengkap) ? 'YES' : 'NO') . "</td><td>" . strlen($nama_lengkap) . "</td></tr>";
            echo "<tr><td>role</td><td>$role</td><td>" . (empty($role) ? 'YES' : 'NO') . "</td><td>" . strlen($role) . "</td></tr>";
            echo "</table>";
            
            // Test validation
            echo "<h3>✅ Validation Checks:</h3>";
            $errors = [];
            
            if (empty($userId) || $userId <= 0) {
                $errors[] = "User ID harus diisi";
            }
            
            if (strlen($username) < 3) {
                $errors[] = "Username minimal 3 karakter";
            }
            
            // Check if username exists (excluding current user)
            $result = $mysqli->query("SELECT COUNT(*) as count FROM tb_user WHERE username = '$username' AND id_user != $userId");
            $count = $result->fetch_assoc()['count'];
            if ($count > 0) {
                $errors[] = "Username '$username' sudah digunakan";
            }
            
            if (empty($role)) {
                $errors[] = "Role harus dipilih";
            }
            
            if (empty($errors)) {
                echo "<p class='success'>✅ All validation checks passed</p>";
                
                // Test database update
                echo "<h3>💾 Database Update Test:</h3>";
                
                $data = [
                    'username' => $username,
                    'nama_lengkap' => $nama_lengkap,
                    'role' => $role
                ];
                
                // Add password only if provided
                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                
                echo "<p>Mencoba update user ID: $userId</p>";
                
                $stmt = $mysqli->prepare("UPDATE tb_user SET username = ?, nama_lengkap = ?, role = ?" . 
                    (!empty($password) ? ", password = ?" : "") . " WHERE id_user = ?");
                $stmt->bind_param('sssi' . (!empty($password) ? 's' : ''), $username, $nama_lengkap, $role, $password, $userId);
                
                if ($stmt->execute()) {
                    echo "<p class='success'>✅ SUCCESS: User berhasil diupdate!</p>";
                    
                    // Verify update
                    $result = $mysqli->query("SELECT * FROM tb_user WHERE id_user = $userId");
                    $user = $result->fetch_assoc();
                    echo "<p class='success'>✅ VERIFICATION: User {$user['username']} berhasil diupdate</p>";
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
        <h3>🔧 Test Edit User Form</h3>
        <form method="post">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required min="1" value="1">
                <small>ID user yang akan diedit</small>
            </div>
            
            <div class="form-group">
                <label for="username">Username Baru:</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="100" value="testuser_updated">
                <small>Minimal 3 karakter, harus unique</small>
            </div>
            
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap Baru:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" maxlength="255" value="Test User Updated">
                <small>Maksimal 255 karakter</small>
            </div>
            
            <div class="form-group">
                <label for="role">Role Baru:</label>
                <select id="role" name="role" required>
                    <option value="petugas" selected>Petugas</option>
                    <option value="admin">Admin</option>
                    <option value="owner">Owner</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="password">Password Baru:</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                <small>Kosongkan jika tidak ingin mengubah password</small>
            </div>
            
            <button type="submit" class="btn btn-success">Test Update User</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>📋 Test Scenarios:</h3>
        <ol>
            <li><strong>Test 1:</strong> Update username saja (password kosong)</li>
            <li><strong>Test 2:</strong> Update username + nama lengkap (password kosong)</li>
            <li><strong>Test 3:</strong> Update username + role (password kosong)</li>
            <li><strong>Test 4:</strong> Update semua field termasuk password</li>
            <li><strong>Test 5:</strong> Coba update dengan username yang sudah ada</li>
        </ol>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Links</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/users" class="btn">User Management</a> |
            <a href="/create_user_with_validation.php" class="btn">Create User Test</a>
        </p>
    </div>
    
    <div class="test-section">
        <h3>📝 Expected Results:</h3>
        <ul>
            <li>✅ <strong>Validation:</strong> Semua field valid</li>
            <li>✅ <strong>Update:</strong> User berhasil diupdate di database</li>
            <li>✅ <strong>Password kosong:</strong> Password tidak berubah jika dikosongkan</li>
            <li>✅ <strong>Password diisi:</strong> Password di-hash dan diupdate jika diisi</li>
        </ul>
    </div>
</body>
</html>
