<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi;
use App\Models\LogAktivitas;

class RekapTransaksiController extends BaseController
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
        
        if (!in_array(session()->get('role'), ['admin', 'superadmin', 'petugas'])) {
            session()->setFlashdata('error', 'Akses ditolak! Hanya admin, superadmin, dan petugas yang dapat mengakses halaman ini.');
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

        // Ambil parameter tanggal dari GET
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-d');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        // Debug: Log parameter
        log_message('debug', 'RekapTransaksi::index - tanggal_awal: ' . $tanggal_awal . ', tanggal_akhir: ' . $tanggal_akhir);

        // Jika ada parameter tanggal, tampilkan rekap
        if ($this->request->getGet('tanggal_awal') || $this->request->getGet('tanggal_akhir')) {
            log_message('debug', 'RekapTransaksi::index - Memanggil rekapTransaksi');
            return $this->rekapTransaksi();
        }

        $data = [
            'title' => 'Rekap Transaksi',
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ];

        log_message('debug', 'RekapTransaksi::index - Menampilkan view index');
        return view('rekap-transaksi/index', $data);
    }

    public function rekapTransaksi()
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

        // Ambil data transaksi berdasarkan tanggal
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
}
