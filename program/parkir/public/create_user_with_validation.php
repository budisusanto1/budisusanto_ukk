<?php
// Create user dengan validasi real-time
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create User dengan Validasi Real-time</title>
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
    <h1>👤 Create User dengan Validasi Real-time</h1>
    
    <?php
    $validation_result = '';
    $validation_class = '';
    
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
            
            // Real-time validation
            $errors = [];
            
            if (strlen($username) < 3) {
                $errors[] = "Username minimal 3 karakter";
            }
            
            if (strlen($password) < 6) {
                $errors[] = "Password minimal 6 karakter (saat ini: " . strlen($password) . " karakter)";
            }
            
            if (!in_array($role, ['admin', 'superadmin', 'petugas'])) {
                $errors[] = "Role tidak valid";
            }
            
            // Check unique username
            $result = $mysqli->query("SELECT COUNT(*) as count FROM tb_user WHERE username = '$username'");
            $count = $result->fetch_assoc()['count'];
            if ($count > 0) {
                $errors[] = "Username '$username' sudah digunakan";
            }
            
            if (empty($errors)) {
                // Try to save
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $mysqli->prepare("INSERT INTO tb_user (username, password, nama_lengkap, role) VALUES (?, ?, ?, ?)");
                $stmt->bind_param('ssss', $username, $hashed_password, $nama_lengkap, $role);
                
                if ($stmt->execute()) {
                    $userId = $mysqli->insert_id;
                    $validation_result = "✅ User '$username' berhasil dibuat dengan ID: $userId";
                    $validation_class = 'success';
                    
                    // Clean up test data
                    $stmt = $mysqli->prepare("DELETE FROM tb_user WHERE id_user = ?");
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    $validation_result = "❌ Gagal menyimpan user: " . $stmt->error;
                    $validation_class = 'error';
                }
                $stmt->close();
            } else {
                $validation_result = "❌ " . implode(', ', $errors);
                $validation_class = 'error';
            }
            
            $mysqli->close();
            
        } catch (Exception $e) {
            $validation_result = "❌ Error: " . $e->getMessage();
            $validation_class = 'error';
        }
    }
    ?>
    
    <?php if (!empty($validation_result)): ?>
        <div class="test-section">
            <div class="validation-message <?php echo $validation_class; ?>">
                <?php echo $validation_result; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="test-section">
        <h3>📝 Form Create User</h3>
        <form method="post" id="userForm">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required minlength="3" maxlength="100" 
                       value="<?php echo $_POST['username'] ?? ''; ?>"
                       oninput="validateUsername()">
                <div id="usernameValidation" class="validation-message"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="6" 
                       oninput="validatePassword()"
                       placeholder="Minimal 6 karakter">
                <div id="passwordValidation" class="validation-message"></div>
                <div id="passwordStrength" class="password-strength"></div>
            </div>
            
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" maxlength="255" 
                       value="<?php echo $_POST['nama_lengkap'] ?? ''; ?>"
                       oninput="validateNamaLengkap()">
                <div id="namaValidation" class="validation-message"></div>
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" onchange="validateRole()">
                    <option value="">Pilih Role</option>
                    <option value="petugas" <?php echo (($_POST['role'] ?? '') == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                    <option value="admin" <?php echo (($_POST['role'] ?? '') == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="superadmin" <?php echo (($_POST['role'] ?? '') == 'superadmin') ? 'selected' : ''; ?>>Superadmin</option>
                </select>
                <div id="roleValidation" class="validation-message"></div>
            </div>
            
            <button type="submit" class="btn btn-success" id="submitBtn">Create User</button>
        </form>
    </div>
    
    <div class="test-section">
        <h3>🧪 Test Password Validation</h3>
        <p>Coba masukkan password dengan karakter berbeda:</p>
        <button onclick="testPassword('123')" class="btn">Test: 3 karakter</button>
        <button onclick="testPassword('12345')" class="btn">Test: 5 karakter</button>
        <button onclick="testPassword('123456')" class="btn">Test: 6 karakter (valid)</button>
        <button onclick="testPassword('1234567')" class="btn">Test: 7 karakter</button>
    </div>
    
    <div class="test-section">
        <h3>📊 Validasi Info</h3>
        <ul>
            <li><strong>Username:</strong> Minimal 3 karakter, maksimal 100 karakter, harus unique</li>
            <li><strong>Password:</strong> Minimal 6 karakter, akan di-hash otomatis</li>
            <li><strong>Nama Lengkap:</strong> Maksimal 255 karakter, boleh kosong</li>
            <li><strong>Role:</strong> Harus dipilih (petugas, admin, superadmin)</li>
        </ul>
    </div>
    
    <div class="test-section">
        <h3>🔗 Quick Links</h3>
        <p>
            <a href="/auth/login" class="btn">Login</a> |
            <a href="/dashboard" class="btn">Dashboard</a> |
            <a href="/users" class="btn">User Management</a> |
            <a href="/debug_create_user.php" class="btn">Debug Mode</a>
        </p>
    </div>
    
    <script>
        function validateUsername() {
            const username = document.getElementById('username').value;
            const validation = document.getElementById('usernameValidation');
            
            if (username.length < 3) {
                validation.textContent = '❌ Username minimal 3 karakter (saat ini: ' + username.length + ')';
                validation.className = 'validation-message error';
                document.getElementById('username').classList.add('error');
            } else if (username.length > 100) {
                validation.textContent = '❌ Username maksimal 100 karakter (saat ini: ' + username.length + ')';
                validation.className = 'validation-message error';
                document.getElementById('username').classList.add('error');
            } else {
                validation.textContent = '✅ Username valid';
                validation.className = 'validation-message success';
                document.getElementById('username').classList.remove('error');
            }
        }
        
        function validatePassword() {
            const password = document.getElementById('password').value;
            const validation = document.getElementById('passwordValidation');
            const strength = document.getElementById('passwordStrength');
            
            if (password.length < 6) {
                validation.textContent = '⚠️ Password minimal 6 karakter! Saat ini: ' + password.length + ' karakter';
                validation.className = 'validation-message warning';
                document.getElementById('password').classList.add('error');
                strength.textContent = '';
                strength.className = 'password-strength';
            } else if (password.length < 8) {
                validation.textContent = '✅ Password valid (lemah)';
                validation.className = 'validation-message success';
                document.getElementById('password').classList.remove('error');
                strength.textContent = '💪 Kekuatan: Lemah';
                strength.className = 'password-strength weak';
            } else if (password.length < 12) {
                validation.textContent = '✅ Password valid (sedang)';
                validation.className = 'validation-message success';
                document.getElementById('password').classList.remove('error');
                strength.textContent = '💪 Kekuatan: Sedang';
                strength.className = 'password-strength medium';
            } else {
                validation.textContent = '✅ Password valid (kuat)';
                validation.className = 'validation-message success';
                document.getElementById('password').classList.remove('error');
                strength.textContent = '💪 Kekuatan: Kuat';
                strength.className = 'password-strength strong';
            }
        }
        
        function validateNamaLengkap() {
            const nama = document.getElementById('nama_lengkap').value;
            const validation = document.getElementById('namaValidation');
            
            if (nama.length > 255) {
                validation.textContent = '❌ Nama lengkap maksimal 255 karakter';
                validation.className = 'validation-message error';
                document.getElementById('nama_lengkap').classList.add('error');
            } else {
                validation.textContent = '✅ Nama lengkap valid';
                validation.className = 'validation-message success';
                document.getElementById('nama_lengkap').classList.remove('error');
            }
        }
        
        function validateRole() {
            const role = document.getElementById('role').value;
            const validation = document.getElementById('roleValidation');
            
            if (role === '') {
                validation.textContent = '❌ Role harus dipilih';
                validation.className = 'validation-message error';
            } else {
                validation.textContent = '✅ Role valid: ' + role;
                validation.className = 'validation-message success';
            }
        }
        
        function testPassword(password) {
            document.getElementById('password').value = password;
            validatePassword();
        }
        
        // Prevent form submission if validation fails
        document.getElementById('userForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            if (password.length < 6) {
                e.preventDefault();
                alert('❌ Password minimal 6 karakter! Saat ini: ' + password.length + ' karakter');
                return false;
            }
        });
        
        // Initialize validation on load
        window.addEventListener('load', function() {
            validateUsername();
            validatePassword();
            validateNamaLengkap();
            validateRole();
        });
    </script>
</body>
</html>
