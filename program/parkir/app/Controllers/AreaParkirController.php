<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class AreaParkirController extends BaseController
{
    protected $areaModel;
    protected $logModel;

    public function __construct()
    {
        $this->areaModel = new AreaParkir();
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
            'Mengakses halaman Manajemen Area Parkir'
        );

        $data = [
            'title' => 'Manajemen Area Parkir',
            'areas' => $this->areaModel->getAllAreas(),
            'stats' => $this->areaModel->getStatistikArea()
        ];

        return view('area/index', $data);
    }

    public function create()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form tambah area parkir baru'
        );

        return view('area/create');
    }

    public function store()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Debug: Tampilkan data yang diterima
        $nama_area = $this->request->getPost('nama_area');
        $kapasitas = $this->request->getPost('kapasitas');
        $terisi = $this->request->getPost('terisi') ?? 0;
        
        // Debug output (hapus di production)
        log_message('debug', 'Area Store - Nama Area: ' . $nama_area . ', Kapasitas: ' . $kapasitas . ', Terisi: ' . $terisi);
        
        // Validasi input
        if (empty($nama_area) || empty($kapasitas)) {
            return redirect()->back()->withInput()->with('error', 'Nama area dan kapasitas harus diisi!');
        }
        
        if (!is_numeric($kapasitas) || $kapasitas <= 0) {
            return redirect()->back()->withInput()->with('error', 'Kapasitas harus angka positif!');
        }
        
        if (!is_numeric($terisi) || $terisi < 0) {
            return redirect()->back()->withInput()->with('error', 'Terisi harus angka positif atau 0!');
        }
        
        if ($terisi > $kapasitas) {
            return redirect()->back()->withInput()->with('error', 'Terisi tidak boleh melebihi kapasitas!');
        }

        $data = [
            'nama_area' => $nama_area,
            'kapasitas' => (int)$kapasitas,
            'terisi' => (int)$terisi
        ];

        // Debug: Tampilkan data yang akan disimpan
        log_message('debug', 'Data to save: ' . json_encode($data));

        if (!$this->areaModel->save($data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal menambah area parkir: ' . implode(', ', $this->areaModel->errors())
            );
            
            // Debug: Tampilkan error
            log_message('error', 'Area save errors: ' . json_encode($this->areaModel->errors()));
            
            return redirect()->back()->withInput()->with('error', 'Gagal menambah area parkir: ' . implode(', ', $this->areaModel->errors()));
        }

        // Debug: Tampilkan ID yang berhasil disimpan
        $insertId = $this->areaModel->getInsertID();
        log_message('debug', 'Area saved with ID: ' . $insertId);

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'create',
            'area parkir',
            'Area: ' . $data['nama_area'] . ', Kapasitas: ' . $data['kapasitas'] . ', Terisi: ' . $data['terisi']
        );

        return redirect()->to('/area')->with('success', 'Area parkir berhasil ditambahkan');
    }

    public function edit($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Membuka form edit area parkir ID: ' . $id
        );

        $area = $this->areaModel->find($id);
        if (!$area) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal edit area parkir ID: ' . $id . ' - Area tidak ditemukan'
            );
            
            return redirect()->to('/area')->with('error', 'Area parkir tidak ditemukan');
        }

        return view('area/edit', ['area' => $area]);
    }

    public function update($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $area = $this->areaModel->find($id);
        if (!$area) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update area parkir ID: ' . $id . ' - Area tidak ditemukan'
            );
            
            return redirect()->to('/area')->with('error', 'Area parkir tidak ditemukan');
        }

        $data = [
            'nama_area' => $this->request->getPost('nama_area'),
            'kapasitas' => $this->request->getPost('kapasitas')
        ];

        if (!$this->areaModel->update($id, $data)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal update area parkir ID: ' . $id . ' - ' . implode(', ', $this->areaModel->errors())
            );
            
            return redirect()->back()->withInput()->with('error', 'Gagal update area parkir: ' . implode(', ', $this->areaModel->errors()));
        }

        // Log aktivitas berhasil
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'update',
            'area parkir',
            'Area: ' . $area['nama_area'] . ' → ' . $data['nama_area'] . ', Kapasitas: ' . $data['kapasitas']
        );

        return redirect()->to('/area')->with('success', 'Area parkir berhasil diupdate');
    }

    public function delete($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $area = $this->areaModel->find($id);
        if (!$area) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus area parkir ID: ' . $id . ' - Area tidak ditemukan'
            );
            
            return redirect()->to('/area')->with('error', 'Area parkir tidak ditemukan');
        }

        // Log aktivitas sebelum hapus
        $this->logModel->logCRUD(
            session()->get('id_user'),
            'delete',
            'area parkir',
            'Area: ' . $area['nama_area'] . ', Kapasitas: ' . $area['kapasitas'] . ', Terisi: ' . $area['terisi']
        );

        if (!$this->areaModel->delete($id)) {
            // Log aktivitas gagal
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Gagal hapus area parkir ID: ' . $id . ' - ' . $area['nama_area']
            );
            
            return redirect()->to('/area')->with('error', 'Gagal hapus area parkir');
        }

        // Log aktivitas berhasil
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Hapus area parkir: ' . $area['nama_area']
        );

        return redirect()->to('/area')->with('success', 'Area parkir berhasil dihapus');
    }

    public function search()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $keyword = $this->request->get('keyword');
        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword,
            'areas' => $this->areaModel->searchArea($keyword),
            'stats' => $this->areaModel->getStatistikArea()
        ];

        // Log aktivitas search
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Search area parkir dengan keyword: ' . $keyword
        );

        return view('area/index', $data);
    }

    public function resetTerisi($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $area = $this->areaModel->find($id);
        if (!$area) {
            return redirect()->to('/area')->with('error', 'Area tidak ditemukan');
        }

        if ($this->areaModel->updateTerisi($id, 0)) {
            // Log aktivitas
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Reset terisi area: ' . $area['nama_area'] . ' dari ' . $area['terisi'] . ' menjadi 0'
            );
            
            return redirect()->to('/area')->with('success', 'Terisi area berhasil direset');
        }

        return redirect()->to('/area')->with('error', 'Gagal reset terisi area');
    }
}
