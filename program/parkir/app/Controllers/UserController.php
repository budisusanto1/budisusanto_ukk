<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->logModel = new LogAktivitas();
    }

    // Cek role untuk akses
    private function checkRole()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if (!in_array(session()->get('role'), ['admin', 'superadmin'])) {
            session()->setFlashdata('error', 'Akses ditolak!');
            return redirect()->to('/dashboard');
        }
        
        return null;
    }

    public function index()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mengakses halaman Manajemen User'
        );

        // Clear any cache and get fresh data
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->orderBy('id_user', 'DESC')->findAll()
        ];

        return view('user/index', $data);
    }

    public function create()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form tambah user baru'
        );

        $data = [
            'title' => 'Tambah User Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('user/create', $data);
    }

    public function store()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role' => 'petugas' // Set role otomatis ke petugas
        ];

        // Custom validation untuk password length
        $password = $this->request->getPost('password');
        if (strlen($password) < 6) {
            session()->setFlashdata('error', 'Password minimal 6 karakter! Saat ini: ' . strlen($password) . ' karakter');
            return redirect()->back()->withInput();
        }

        if (!$this->userModel->save($data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menambah user: ' . implode(', ', $this->userModel->errors())
            );
            
            return redirect()->back()->withInput()->with('error', 'Gagal menambah user: ' . implode(', ', $this->userModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logRegister($this->userModel->getInsertID(), $data['username']);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form edit user ID: ' . $id
        );

        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->find($id)
        ];

        if (!$data['user']) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal edit user ID: ' . $id . ' - User tidak ditemukan'
            );
            
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $user = $this->userModel->find($id);
        if (!$user) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update user ID: ' . $id . ' - User tidak ditemukan'
            );
            
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        if (!$this->userModel->update($id, $data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update user ID: ' . $id . ' - ' . implode(', ', $this->userModel->errors())
            );
            
            return redirect()->back()->withInput()->with('error', 'Gagal update user: ' . implode(', ', $this->userModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'update',
            'user',
            'Username: ' . $user['username'] . ' → ' . $this->request->getPost('username')
        );

        return redirect()->to('/users')->with('success', 'User berhasil diupdate');
    }

    public function delete($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $user = $this->userModel->find($id);
        if (!$user) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus user ID: ' . $id . ' - User tidak ditemukan'
            );
            
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        // Log aktivitas sebelum hapus
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'delete',
            'user',
            'Username: ' . $user['username'] . ', Role: ' . $user['role']
        );

        if (!$this->userModel->delete($id)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus user ID: ' . $id . ' - ' . $user['username']
            );
            
            return redirect()->to('/users')->with('error', 'Gagal hapus user');
        }

        // Log aktivitas berhasil
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Hapus user: ' . $user['username']
        );

        return redirect()->to('/users')->with('success', 'User berhasil dihapus');
    }
}
