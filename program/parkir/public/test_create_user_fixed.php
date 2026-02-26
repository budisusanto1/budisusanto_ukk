<?php
// Test create user yang sudah diperbaiki
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Create User (Fixed)</title>
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
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 300px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .validation-message { margin-top: 5px; font-size: 14px; }
        .validation-message.error { color: red; font-weight: bold; }
        .validation-message.warning { color: orange; font-weight: bold; }
        .validation-message.success { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>✅ Test Create User (Fixed Version)</h1>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $mysqli = new mysqli('localhost', 'root', '', 'parkir');
            
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            // Get form data
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $role = $_POST['role'] ?? 'petugas';
            
            echo "<div class='test-section'>";
            echo "<h2>📊 Form Submission Analysis</h2>";
            
            // Validation
            $errors = [];
            
            if (strlen($username) < 3) {
                $errors[] = "Username minimal 3 karakter";
            }
            
            if (strlen($password) < 6) {
                $errors[] = "Password minimal 6 karakter (saat ini: " . strlen($password) . ")";
            }
            
            // Check unique username
            $result = $mysqli->query("SELECT COUNT(*) as count FROM tb_user WHERE username = '$username'");
            $count = $result->fetch_assoc()['count'];
            if ($count > 0) {
                $errors[] = "Username '$username' sudah digunakan";
            }
            
            if (empty($errors)) {
                // Simulate UserController logic
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('ssss', $username, $hashed_password, $nama_lengkap, $role);
                
                if ($stmt->execute()) {
                    $userId = $mysqli->insert_id;
                    echo "<p class='success'>✅ SUCCESS: User '$username' berhasil dibuat dengan ID: $userId</p>";
                    echo "<p class='info'>📝 Setelah create user, seharusnya redirect ke /users (index user management)</p>";
                    echo "<p class='info'>📝 BUKAN redirect ke /auth/login</p>";
                    
                    // Clean up test data
                    $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "<p class='error'>❌ FAILED: " . $stmt->error . "</p>";
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
        <h3>📝 Form Create User (Fixed)</h3>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="100" 
                       value="<?php echo $_POST['username'] ?? 'testuser_' . time(); ?>">
                <small>Minimal 3 karakter, harus unique</small>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="6" 
                       placeholder="Minimal 6 karakter">
                <small>⚠️ Akan ditolak jika kurang dari 6 karakter</small>
            </div>
            
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" maxlength="255" 
                       value="<?php echo $_POST['nama_lengkap'] ?? 'Test User Fixed'; ?>">
                <small>Maksimal 255 karakter, boleh kosong</small>
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="petugas" selected>Petugas</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-success">Create User (Fixed Version)</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>🔧 What's Fixed:</h3>
        <ul>
            <li>✅ <strong>Password validation</strong>: Menunjukkan warning jika kurang dari 6 karakter</li>
            <li>✅ <strong>Redirect fix</strong>: Setelah create user, redirect ke /users bukan /auth/login</li>
            <li>✅ <strong>Better error messages</strong>: Menunjukkan jumlah karakter saat ini</li>
            <li>✅ <strong>Real-time validation</strong>: Feedback langsung saat user mengetik</li>
        </ul>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Links</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/users" class="btn">User Management (Fixed)</a> |
            <a href="/create_user_with_validation.php" class="btn">Real-time Validation</a>
        </p>
    </div>
    
    <div class="test-section">
        <h3>📋 Test Scenarios:</h3>
        <ol>
            <li><strong>Test 1:</strong> Password 3 karakter → Harus ditolak dengan warning</li>
            <li><strong>Test 2:</strong> Password 5 karakter → Harus ditolak dengan warning</li>
            <li><strong>Test 3:</strong> Password 6 karakter → Harus berhasil dan redirect ke /users</li>
            <li><strong>Test 4:</strong> Username sudah ada → Harus ditolak dengan error</li>
        </ol>
    </div>
</body>
</html>
