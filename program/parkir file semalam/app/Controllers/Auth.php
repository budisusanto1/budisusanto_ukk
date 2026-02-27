<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Libraries\RecaptchaLibrary;
use App\Models\LogAktivitas;

class Auth extends BaseController
{
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->logModel = new LogAktivitas();
    }

    public function register()
    {
        // Log aktivitas akses register page (guest)
        if (!session()->get('isLoggedIn')) {
            $this->logModel->logActivity(
                null, // NULL untuk guest
                'Mengakses halaman register (guest)'
            );
        }

        // Jika method adalah POST, proses registrasi
        if ($this->request->getMethod() === 'POST') {
            $data = [
                'username' => $this->request->getPost('username'),
                'password' => $this->request->getPost('password'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'role' => 'petugas', // Set role otomatis ke petugas
            ];

            // Validasi input
            if (!$this->userModel->save($data)) {
                // Log aktivitas gagal
                $this->logModel->logActivity(
                    null, // NULL untuk guest
                    'Gagal registrasi: ' . implode(', ', $this->userModel->errors())
                );
                
                return view('auth/register', [
                    'validation' => $this->userModel->validation,
                    'old_input' => $this->request->getPost()
                ]);
            }

            // Log aktivitas register berhasil
            $this->logModel->logRegister($this->userModel->getInsertID(), $data['username']);

            return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil! Silakan login dengan username: ' . $data['username']);
        }

        // Tampilkan form registrasi
        return view('auth/register');
    }

    public function login()
    {
        // Log aktivitas akses login page (guest)
        if (!session()->get('isLoggedIn')) {
            $this->logModel->logActivity(
                null, // NULL untuk guest
                'Mengakses halaman login (guest)'
            );
        }

        // Jika method adalah POST, proses login
        if ($this->request->getMethod() === 'POST') {
            $recaptcha = new RecaptchaLibrary();
            $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
            
            // Validasi reCAPTCHA
            if (empty($recaptchaResponse) || !$recaptcha->verifyResponse($recaptchaResponse)) {
                session()->setFlashdata('error', 'Silakan verifikasi bahwa Anda bukan robot!');
                return redirect()->to('/auth/login');
            }
            
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            // Cari user berdasarkan username
            $user = $this->userModel->where('username', $username)->first();
            
            if (!$user) {
                // Log aktivitas gagal login
                $this->logModel->logActivity(
                    null, // NULL untuk guest
                    'Gagal login - Username tidak ditemukan: ' . $username
                );
                
                session()->setFlashdata('error', 'Username tidak ditemukan! Silakan periksa kembali username Anda.');
                return redirect()->to('/auth/login');
            } else if (!password_verify($password, $user['password'])) {
                // Log aktivitas gagal login
                $this->logModel->logActivity(
                    null, // NULL untuk guest
                    'Gagal login - Password salah untuk username: ' . $username
                );
                
                session()->setFlashdata('error', 'Password salah! Silakan periksa kembali password Anda.');
                return redirect()->to('/auth/login');
            } else {
                // Verifikasi password
                // Set session data
                $sessionData = [
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                
                session()->set($sessionData);
                
                // Log aktivitas login berhasil
                try {
                    $logResult = $this->logModel->logLogin($user['id_user'], $user['username']);
                    log_message('info', 'Login log created for user ' . $user['username'] . ' with log ID: ' . $logResult);
                } catch (\Exception $e) {
                    log_message('error', 'Failed to create login log: ' . $e->getMessage());
                }
                
                // Redirect ke dashboard setelah login berhasil
                return redirect()->to('/dashboard')->with('success', 'Login berhasil! Selamat datang ' . $user['username']);
            }
        }

        // Tampilkan form login
        return view('auth/login');
    }

    public function logout()
    {
        // Log aktivitas logout
        if (session()->get('isLoggedIn')) {
            $this->logModel->logLogout(session()->get('id_user'));
        }

        // Hapus session
        session()->destroy();
        
        return redirect()->to('/')->with('success', 'Logout berhasil!');
    }

    public function index()
    {
        return redirect()->to('/auth/login');
    }
}
