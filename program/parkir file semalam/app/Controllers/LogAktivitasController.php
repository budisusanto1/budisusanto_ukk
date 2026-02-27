<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktivitas;
use CodeIgniter\HTTP\ResponseInterface;

class LogAktivitasController extends BaseController
{
    protected $logModel;

    public function __construct()
    {
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
            'Mengakses halaman Log Aktivitas'
        );

        // Debug: Cek total logs
        try {
            $allLogs = $this->logModel->findAll();
            log_message('debug', 'LogAktivitasController - Total logs in database: ' . count($allLogs));
            
            $logs = $this->logModel->getLogsWithUser(100, 0);
            log_message('debug', 'LogAktivitasController - Logs with user: ' . count($logs));
            
            $data = [
                'title' => 'Log Aktivitas Sistem',
                'logs' => $logs,
                'total_logs' => count($allLogs)
            ];
        } catch (\Exception $e) {
            log_message('error', 'LogAktivitasController - Error: ' . $e->getMessage());
            
            $data = [
                'title' => 'Log Aktivitas Sistem',
                'logs' => [],
                'total_logs' => 0
            ];
        }

        return view('log/index', $data);
    }

    public function search()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $keyword = $this->request->get('keyword');
        $data = [
            'title' => 'Hasil Pencarian: ' . $keyword,
            'logs' => $this->logModel->searchLogs($keyword)
        ];

        // Log aktivitas search
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Search log aktivitas dengan keyword: ' . $keyword
        );

        return view('log/index', $data);
    }

    public function filterByDate()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');

        $data = [
            'title' => 'Log Aktivitas: ' . $tanggal_awal . ' - ' . $tanggal_akhir,
            'logs' => $this->logModel->getLogsByDateRange($tanggal_awal, $tanggal_akhir)
        ];

        // Log aktivitas filter
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Filter log aktivitas dari ' . $tanggal_awal . ' hingga ' . $tanggal_akhir
        );

        return view('log/index', $data);
    }

    public function detail($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Melihat detail log aktivitas ID: ' . $id
        );

        $data = [
            'title' => 'Detail Log Aktivitas',
            'log' => $this->logModel->getLogsWithUser($id)
        ];

        return view('log/detail', $data);
    }

    public function export()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $tanggal_awal = $this->request->get('tanggal_awal');
        $tanggal_akhir = $this->request->get('tanggal_akhir');

        $logs = $this->logModel->getLogsByDateRange($tanggal_awal, $tanggal_akhir);

        // Log aktivitas export
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Export log aktivitas dari ' . $tanggal_awal . ' hingga ' . $tanggal_akhir
        );

        // Create CSV export
        $filename = 'log_aktivitas_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');

        // Header CSV
        fputcsv($output, ['ID', 'Username', 'Nama Lengkap', 'Aktivitas', 'Waktu', 'IP Address']);

        // Data CSV
        foreach ($logs as $log) {
            fputcsv($output, [
                $log['id_log'],
                $log['username'],
                $log['nama_lengkap'],
                $log['aktivitas'],
                $log['waktu_aktivitas'],
                $log['ip_address']
            ]);
        }

        fclose($output);
        exit;
    }

    public function cleanup()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $days_old = $this->request->getPost('days_old') ?? 90;
        
        if ($this->logModel->cleanOldLogs($days_old)) {
            // Log aktivitas cleanup
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Cleanup log aktivitas lama (' . $days_old . ' hari)'
            );
            
            return redirect()->to('/log')->with('success', 'Log aktivitas lama berhasil dihapus');
        }

        return redirect()->to('/log')->with('error', 'Gagal menghapus log aktivitas lama');
    }

    public function statistics()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $tanggal_awal = $this->request->get('tanggal_awal') ?? date('Y-m-d', strtotime('-30 days'));
        $tanggal_akhir = $this->request->get('tanggal_akhir') ?? date('Y-m-d');

        $data = [
            'title' => 'Statistik Log Aktivitas',
            'stats' => $this->logModel->getAktivitasStats($tanggal_awal, $tanggal_akhir),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ];

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Melihat statistik log aktivitas'
        );

        return view('log/statistics', $data);
    }
}
