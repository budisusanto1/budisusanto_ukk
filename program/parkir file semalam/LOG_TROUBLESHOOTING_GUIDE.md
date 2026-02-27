# Log Aktivitas Troubleshooting Guide

## 🎯 Masalah Utama
"Log aktivitas tidak terbaca saat login"

## ✅ Status Verifikasi
- ✅ Database connection: OK
- ✅ Table tb_log_aktivitas: Exists
- ✅ Foreign key: Fixed (id_user nullable)
- ✅ Model functions: Working
- ✅ Data insert: Working
- ✅ Data retrieval: Working

## 🔍 Kemungkinan Penyebab

### 1. reCAPTCHA Validation
**Gejala:** Login gagal, tidak ada log tercatat
**Solusi:** 
- Check reCAPTCHA settings di `.env`
- Test login tanpa reCAPTCHA (disable sementara)

### 2. Session Issues
**Gejala:** Login berhasil tapi log tidak tercatat
**Solusi:**
- Pastikan session tersimpan sebelum logging
- Check session configuration

### 3. Error Handling
**Gejala:** Error tidak visible ke user
**Solusi:**
- Enable error logging
- Check `writable/logs` untuk error messages

### 4. Redirect Timing
**Gejala:** Log tercatat tapi langsung redirect
**Solusi:**
- Add delay atau check log setelah redirect
- Use log_message() untuk debugging

## 🛠️ Testing Commands

### 1. Test Database Connection
```bash
php simple_log_test.php
```

### 2. Test via Web
Access: `http://localhost:8080/simple_test.php`

### 3. Test Login Simulation
Access: `http://localhost:8080/test_login_simulation.php`

### 4. Check Recent Logs
```sql
SELECT la.*, u.username, u.nama_lengkap 
FROM tb_log_aktivitas la 
LEFT JOIN tb_user u ON la.id_user = u.id_user 
ORDER BY la.waktu_aktivitas DESC 
LIMIT 10;
```

## 📝 Debug Steps

### Step 1: Verify Login Process
1. Buka `http://localhost:8080/auth/login`
2. Login dengan user yang ada
3. Check apakah redirect berhasil ke dashboard

### Step 2: Check Database
1. Access `http://localhost:8080/simple_test.php`
2. Lihat apakah log tercatat
3. Check recent logs table

### Step 3: Monitor Logs
1. Enable error logging di `app/Config/Logger.php`
2. Check `writable/logs/` untuk error messages
3. Look for "Failed to create login log" messages

### Step 4: Test Manual Insert
1. Use `test_login_simulation.php`
2. Simulate login process
3. Verify logs created successfully

## 🔧 Configuration Check

### .env Settings
```env
CI_ENVIRONMENT = development
app.baseURL = http://localhost:8080/
database.default.hostname = localhost
database.default.database = parkir
database.default.username = root
database.default.password = 
```

### Logger Config (app/Config/Logger.php)
```php
public $threshold = (ENVIRONMENT === 'production') ? 4 : 9;
```

## 🎯 Quick Fix

Jika log tidak tercatat saat login:

1. **Disable reCAPTCHA sementara:**
   - Comment reCAPTCHA validation di `Auth.php`
   - Test login tanpa reCAPTCHA

2. **Enable Debug Logging:**
   - Set `CI_ENVIRONMENT = development` di `.env`
   - Check log messages

3. **Check Session:**
   - Pastikan session start sebelum logging
   - Verify session data tersimpan

## 📊 Expected Behavior

### Normal Login Flow:
1. User submit login form
2. reCAPTCHA validation (if enabled)
3. User authentication
4. Session creation
5. **Login log created** ✅
6. Redirect to dashboard
7. **Dashboard access log created** ✅

### Log Should Contain:
- `id_user`: User ID
- `aktivitas`: "Login berhasil (Username: xxx)"
- `waktu_aktivitas`: Current timestamp
- `ip_address`: User IP
- `user_agent`: Browser info

## 🚨 If Still Not Working

1. Check Apache/Nginx error logs
2. Verify PHP error reporting enabled
3. Check database permissions
4. Test with different user accounts
5. Clear session and cache

## 📞 Support

Jika masalah berlanjut:
1. Provide error messages from logs
2. Share screenshots of login process
3. Include database query results
4. Show browser console errors
