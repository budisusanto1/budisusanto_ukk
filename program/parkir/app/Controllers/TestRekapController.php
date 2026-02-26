<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi;
use App\Models\LogAktivitas;

class TestRekapController extends BaseController
{
    protected $transaksiModel;
    protected $logModel;

    public function __construct()
    {
        $this->transaksiModel = new Transaksi();
        $this->logModel = new LogAktivitas();
    }

    // Cek role untuk akses
    private function checkRole()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        // Izinkan petugas, admin, superadmin, dan owner
        if (!in_array(session()->get('role'), ['petugas', 'admin', 'superadmin', 'owner'])) {
            session()->setFlashdata('error', 'Akses ditolak! Hanya petugas, admin, superadmin, dan owner yang dapat mengakses halaman ini.');
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
            'Mengakses halaman Rekap Transaksi'
        );

        // Ambil parameter tanggal
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-d');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        // Jika ada parameter tanggal, tampilkan data
        if ($this->request->getGet('tanggal_awal') || $this->request->getGet('tanggal_akhir')) {
            // Ambil data transaksi
            $transaksi = $this->transaksiModel->getRekapByDate($tanggal_awal, $tanggal_akhir);
            
            $data = [
                'title' => 'Rekap Transaksi',
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
                'transaksi' => $transaksi,
                'total_transaksi' => count($transaksi),
                'total_pendapatan' => array_sum(array_column($transaksi, 'biaya_total'))
            ];

            return view('rekap-transaksi/detail', $data);
        }

        // Tampilkan form filter
        $data = [
            'title' => 'Rekap Transaksi',
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ];

        return view('rekap-transaksi/index', $data);
    }

    public function cetakStruk($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $transaksi = $this->transaksiModel->getTransaksiWithRelations($id);
        if (!$transaksi) {
            return redirect()->to('/rekap-transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mencetak struk transaksi: ' . $transaksi['plat_nomor']
        );

        $data = [
            'title' => 'Cetak Struk',
            'transaksi' => $transaksi
        ];

        return view('transaksi/struk', $data);
    }
}
