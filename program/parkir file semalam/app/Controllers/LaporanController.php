<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi;
use App\Models\LogAktivitas;

class LaporanController extends BaseController
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
        
        if (!in_array(session()->get('role'), ['admin', 'superadmin', 'owner'])) {
            session()->setFlashdata('error', 'Akses ditolak! Hanya admin, superadmin, dan owner yang dapat mengakses halaman ini.');
            return redirect()->to('/dashboard');
        }
        
        return null;
    }

    public function pendapatan()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mengakses halaman Laporan Pendapatan'
        );

        // Ambil parameter tanggal
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-d');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        // Ambil data pendapatan
        $transaksi = $this->transaksiModel->getRekapByDate($tanggal_awal, $tanggal_akhir);
        
        // Group by date untuk statistik harian
        $statistik_harian = [];
        foreach ($transaksi as $t) {
            $tanggal = date('Y-m-d', strtotime($t['waktu_masuk']));
            if (!isset($statistik_harian[$tanggal])) {
                $statistik_harian[$tanggal] = [
                    'tanggal' => $tanggal,
                    'total_transaksi' => 0,
                    'total_pendapatan' => 0
                ];
            }
            $statistik_harian[$tanggal]['total_transaksi']++;
            $statistik_harian[$tanggal]['total_pendapatan'] += $t['biaya_total'];
        }

        $data = [
            'title' => 'Laporan Pendapatan',
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'transaksi' => $transaksi,
            'total_transaksi' => count($transaksi),
            'total_pendapatan' => array_sum(array_column($transaksi, 'biaya_total')),
            'statistik_harian' => array_values($statistik_harian)
        ];

        return view('laporan/pendapatan', $data);
    }

    public function statistik()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mengakses halaman Statistik Parkir'
        );

        // Ambil parameter tanggal
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-d', strtotime('-30 days'));
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        // Ambil data transaksi
        $transaksi = $this->transaksiModel->getRekapByDate($tanggal_awal, $tanggal_akhir);

        // Statistik per jenis kendaraan
        $statistik_kendaraan = [];
        foreach ($transaksi as $t) {
            $jenis = $t['jenis_kendaraan'];
            if (!isset($statistik_kendaraan[$jenis])) {
                $statistik_kendaraan[$jenis] = [
                    'jenis_kendaraan' => $jenis,
                    'total_transaksi' => 0,
                    'total_pendapatan' => 0,
                    'rata_durasi' => 0
                ];
            }
            $statistik_kendaraan[$jenis]['total_transaksi']++;
            $statistik_kendaraan[$jenis]['total_pendapatan'] += $t['biaya_total'];
            $statistik_kendaraan[$jenis]['rata_durasi'] += $t['durasi_jam'];
        }

        // Hitung rata-rata durasi
        foreach ($statistik_kendaraan as &$stat) {
            if ($stat['total_transaksi'] > 0) {
                $stat['rata_durasi'] = $stat['rata_durasi'] / $stat['total_transaksi'];
            }
        }

        $data = [
            'title' => 'Statistik Parkir',
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'transaksi' => $transaksi,
            'total_transaksi' => count($transaksi),
            'total_pendapatan' => array_sum(array_column($transaksi, 'biaya_total')),
            'statistik_kendaraan' => array_values($statistik_kendaraan)
        ];

        return view('laporan/statistik', $data);
    }

    public function exportExcel()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Ambil parameter tanggal
        $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-01');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

        // Ambil data pendapatan
        $transaksi = $this->transaksiModel->getRekapByDate($tanggal_awal, $tanggal_akhir);
        
        // Group by date untuk statistik harian
        $statistik_harian = [];
        $statistik_metode_pembayaran = [];
        
        foreach ($transaksi as $t) {
            $tanggal = date('Y-m-d', strtotime($t['waktu_masuk']));
            if (!isset($statistik_harian[$tanggal])) {
                $statistik_harian[$tanggal] = [
                    'tanggal' => $tanggal,
                    'total_transaksi' => 0,
                    'total_pendapatan' => 0
                ];
            }
            $statistik_harian[$tanggal]['total_transaksi']++;
            $statistik_harian[$tanggal]['total_pendapatan'] += $t['biaya_total'];
            
            // Statistik metode pembayaran
            $metode = $t['metode_pembayaran'] ?? 'tunai';
            if (!isset($statistik_metode_pembayaran[$metode])) {
                $statistik_metode_pembayaran[$metode] = [
                    'metode_pembayaran' => $metode,
                    'total_transaksi' => 0,
                    'total_pendapatan' => 0
                ];
            }
            $statistik_metode_pembayaran[$metode]['total_transaksi']++;
            $statistik_metode_pembayaran[$metode]['total_pendapatan'] += $t['biaya_total'];
        }

        // Siapkan data untuk view
        $data = [
            'title' => 'Laporan Pendapatan',
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'transaksi' => $transaksi,
            'total_transaksi' => count($transaksi),
            'total_pendapatan' => array_sum(array_column($transaksi, 'biaya_total')),
            'statistik_harian' => array_values($statistik_harian),
            'statistik_metode_pembayaran' => array_values($statistik_metode_pembayaran)
        ];

        return view('laporan/pendapatan_excel', $data);
    }
}
