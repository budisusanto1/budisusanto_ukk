<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogAktivitas();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        // Log aktivitas akses dashboard
        try {
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Mengakses halaman Dashboard'
            );
            log_message('info', 'Dashboard access logged for user ID: ' . session()->get('id_user'));
        } catch (\Exception $e) {
            log_message('error', 'Failed to log dashboard access: ' . $e->getMessage());
        }

        $data = [
            'user' => [
                'username' => session()->get('username'),
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role')
            ]
        ];

        // Cek role dan tampilkan view yang sesuai
        $role = session()->get('role');
        
        if ($role === 'owner') {
            return view('dashboard/owner', $data);
        } elseif (in_array($role, ['admin', 'superadmin'])) {
            return view('dashboard/index', $data);
        } elseif ($role === 'petugas') {
            return view('dashboard/petugas', $data);
        } else {
            return view('dashboard/user', $data);
        }
    }
}
