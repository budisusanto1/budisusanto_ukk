<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class KendaraanController extends BaseController
{
    protected $kendaraanModel;
    protected $logModel;

    public function __construct()
    {
        $this->kendaraanModel = new Kendaraan();
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
            'Mengakses halaman Manajemen Kendaraan'
        );

        $data = [
            'title' => 'Manajemen Kendaraan',
            'kendaraan' => $this->kendaraanModel->getKendaraanWithUser()
        ];

        return view('kendaraan/index', $data);
    }

    public function create()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form tambah kendaraan baru'
        );

        $data = [
            'title' => 'Tambah Kendaraan Baru',
            'users' => $this->kendaraanModel->getKendaraanByUser(session()->get('id_user'))
        ];

        return view('kendaraan/create', $data);
    }

    public function store()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $data = [
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan'),
            'warna' => $this->request->getPost('warna'),
            'pemilik' => $this->request->getPost('pemilik'),
            'id_user' => session()->get('id_user')
        ];

        if (!$this->kendaraanModel->save($data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menambah kendaraan: ' . implode(', ', $this->kendaraanModel->errors())
            );
            
            return redirect()->back()->with('error', 'Gagal menambah kendaraan: ' . implode(', ', $this->kendaraanModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'create',
            'kendaraan',
            'Plat: ' . $data['plat_nomor'] . ', Jenis: ' . $data['jenis_kendaraan']
        );

        return redirect()->to('/kendaraan')->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form edit kendaraan ID: ' . $id
        );

        $data = [
            'title' => 'Edit Kendaraan',
            'kendaraan' => $this->kendaraanModel->find($id),
            'users' => $this->kendaraanModel->getKendaraanByUser(session()->get('id_user'))
        ];

        if (!$data['kendaraan']) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal mengedit kendaraan ID: ' . $id . ' - Kendaraan tidak ditemukan'
            );
            
            return redirect()->to('/kendaraan')->with('error', 'Kendaraan tidak ditemukan');
        }

        return view('kendaraan/edit', $data);
    }

    public function update($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $kendaraan = $this->kendaraanModel->find($id);
        if (!$kendaraan) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update kendaraan ID: ' . $id . ' - Kendaraan tidak ditemukan'
            );
            
            return redirect()->to('/kendaraan')->with('error', 'Kendaraan tidak ditemukan');
        }

        $data = [
            'plat_nomor' => $this->request->getPost('plat_nomor'),
            'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan'),
            'warna' => $this->request->getPost('warna'),
            'pemilik' => $this->request->getPost('pemilik'),
            'id_user' => session()->get('id_user')
        ];

        if (!$this->kendaraanModel->update($id, $data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update kendaraan ID: ' . $id . ' - ' . implode(', ', $this->kendaraanModel->errors())
            );
            
            return redirect()->back()->with('error', 'Gagal mengupdate kendaraan: ' . implode(', ', $this->kendaraanModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'update',
            'kendaraan',
            'Plat: ' . $data['plat_nomor'] . ' → ' . $this->request->getPost('plat_nomor')
        );

        return redirect()->to('/kendaraan')->with('success', 'Kendaraan berhasil diupdate');
    }

    public function delete($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $kendaraan = $this->kendaraanModel->find($id);
        if (!$kendaraan) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menghapus kendaraan ID: ' . $id . ' - Kendaraan tidak ditemukan'
            );
            
            return redirect()->to('/kendaraan')->with('error', 'Kendaraan tidak ditemukan');
        }

        // Log aktivitas sebelum hapus
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'delete',
            'kendaraan',
            'Plat: ' . $kendaraan['plat_nomor'] . ', Jenis: ' . $kendaraan['jenis_kendaraan']
        );

        if (!$this->kendaraanModel->delete($id)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menghapus kendaraan ID: ' . $id . ' - ' . $kendaraan['plat_nomor']
            );
            
            return redirect()->to('/kendaraan')->with('error', 'Gagal menghapus kendaraan');
        }

        // Log aktivitas berhasil
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Hapus kendaraan: ' . $kendaraan['plat_nomor']
        );

        return redirect()->to('/kendaraan')->with('success', 'Kendaraan berhasil dihapus');
    }

    public function search()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $keyword = $this->request->get('keyword');
        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword,
            'kendaraan' => $this->kendaraanModel->searchKendaraan($keyword)
        ];

        // Log aktivitas search
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Search kendaraan dengan keyword: ' . $keyword
        );

        return view('kendaraan/index', $data);
    }
}
