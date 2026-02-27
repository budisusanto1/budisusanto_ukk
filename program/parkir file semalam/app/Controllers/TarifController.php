<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tarif;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class TarifController extends BaseController
{
    protected $tarifModel;
    protected $logModel;

    public function __construct()
    {
        $this->tarifModel = new Tarif();
        $this->logModel = new LogAktivitas();
    }

    // Cek role untuk akses
    private function checkRole()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        if (!in_array(session()->get('role'), ['admin', 'superadmin', 'petugas'])) {
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
            'Mengakses halaman Manajemen Tarif'
        );

        $data = [
            'title' => 'Manajemen Tarif Parkir',
            'tarif' => $this->tarifModel->getAllTarif()
        ];

        return view('tarif/index', $data);
    }

    public function create()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form tambah tarif baru'
        );

        return view('tarif/create');
    }

    public function store()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $data = [
            'jenis_kendaraan' => $this->request->getPost('jenis_kendaraan'),
            'tarif_per_jam' => $this->request->getPost('tarif_per_jam')
        ];

        // Cek apakah tarif untuk jenis kendaraan sudah ada
        if ($this->tarifModel->isTarifExist($data['jenis_kendaraan'])) {
            session()->setFlashdata('error', 'Tarif untuk ' . $data['jenis_kendaraan'] . ' sudah ada!');
            return redirect()->back()->withInput();
        }

        if (!$this->tarifModel->save($data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menambah tarif: ' . implode(', ', $this->tarifModel->errors())
            );
            
            return redirect()->back()->withInput()->with('error', 'Gagal menambah tarif: ' . implode(', ', $this->tarifModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'create',
            'tarif',
            'Jenis: ' . $data['jenis_kendaraan'] . ', Tarif: Rp ' . number_format($data['tarif_per_jam'])
        );

        return redirect()->to('/tarif')->with('success', 'Tarif berhasil ditambahkan');
    }

    public function edit($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form edit tarif ID: ' . $id
        );

        $tarif = $this->tarifModel->find($id);
        if (!$tarif) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal edit tarif ID: ' . $id . ' - Tarif tidak ditemukan'
            );
            
            return redirect()->to('/tarif')->with('error', 'Tarif tidak ditemukan');
        }

        return view('tarif/edit', ['tarif' => $tarif]);
    }

    public function update($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $tarif = $this->tarifModel->find($id);
        if (!$tarif) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update tarif ID: ' . $id . ' - Tarif tidak ditemukan'
            );
            
            return redirect()->to('/tarif')->with('error', 'Tarif tidak ditemukan');
        }

        $data = [
            'tarif_per_jam' => $this->request->getPost('tarif_per_jam')
        ];
        
        $jenis_kendaraan = $this->request->getPost('jenis_kendaraan');

        // Validasi: cek apakah tarif untuk jenis kendaraan sudah ada (exclude current record)
        if ($this->tarifModel->isTarifExist($jenis_kendaraan, $id)) {
            session()->setFlashdata('error', 'Tarif untuk ' . $jenis_kendaraan . ' sudah ada!');
            return redirect()->back()->withInput();
        }

        if (!$this->tarifModel->update($id, $data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update tarif ID: ' . $id . ' - ' . implode(', ', $this->tarifModel->errors())
            );
            
            return redirect()->back()->withInput()->with('error', 'Gagal update tarif: ' . implode(', ', $this->tarifModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'update',
            'tarif',
            'Tarif ' . ucfirst($tarif['jenis_kendaraan']) . ' → Rp ' . number_format($data['tarif_per_jam'])
        );

        return redirect()->to('/tarif')->with('success', 'Tarif berhasil diupdate');
    }

    public function delete($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $tarif = $this->tarifModel->find($id);
        if (!$tarif) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus tarif ID: ' . $id . ' - Tarif tidak ditemukan'
            );
            
            return redirect()->to('/tarif')->with('error', 'Tarif tidak ditemukan');
        }

        // Log aktivitas sebelum hapus
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'delete',
            'tarif',
            'Tarif ' . ucfirst($tarif['jenis_kendaraan'])
        );

        if (!$this->tarifModel->delete($id)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus tarif ID: ' . $id . ' - ' . $tarif['jenis_kendaraan']
            );
            
            return redirect()->to('/tarif')->with('error', 'Gagal hapus tarif');
        }

        // Log aktivitas berhasil
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Hapus tarif: ' . ucfirst($tarif['jenis_kendaraan'])
        );

        return redirect()->to('/tarif')->with('success', 'Tarif berhasil dihapus');
    }
}
