<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $kendaraanModel;
    protected $tarifModel;
    protected $areaModel;
    protected $logModel;

    public function __construct()
    {
        $this->transaksiModel = new Transaksi();
        $this->kendaraanModel = new Kendaraan();
        $this->tarifModel = new Tarif();
        $this->areaModel = new AreaParkir();
        $this->logModel = new LogAktivitas();
    }

    // Cek role untuk akses petugas
    private function checkRole()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }
        
        // Izinkan petugas, admin, superadmin, dan owner untuk akses cetak struk
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
            'Mengakses halaman transaksi masuk'
        );

        $data = [
            'title' => 'Transaksi Masuk',
            'area' => $this->areaModel->findAll(),
            'tarif' => $this->tarifModel->findAll(),
            'transaksi_terakhir' => session()->getFlashdata('id_transaksi_terakhir'),
            'transaksi_aktif' => $this->transaksiModel->getTransaksiAktif()
        ];

        return view('transaksi/masuk', $data);
    }

    public function storeMasuk()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Cek kendaraan berdasarkan plat nomor
        $plat_nomor = $this->request->getPost('no_plat');
        $jenis_kendaraan = $this->request->getPost('jenis_kendaraan');
        
        // Cari kendaraan yang sudah ada atau buat baru
        $kendaraan = $this->kendaraanModel->where('plat_nomor', $plat_nomor)->first();
        
        if (!$kendaraan) {
            // Buat kendaraan baru
            $kendaraanData = [
                'plat_nomor' => $plat_nomor,
                'jenis_kendaraan' => $jenis_kendaraan,
                'pemilik' => 'Tidak Diketahui',
                'warna' => '-'
            ];
            $this->kendaraanModel->save($kendaraanData);
            $id_kendaraan = $this->kendaraanModel->getInsertID();
        } else {
            $id_kendaraan = $kendaraan['id_kendaraan'];
        }

        // Ambil tarif
        $tarif = $this->tarifModel->where('jenis_kendaraan', $jenis_kendaraan)->first();
        $id_tarif = $tarif ? $tarif['id_tarif'] : null;

        $data = [
            'id_kendaraan' => $id_kendaraan,
            'waktu_masuk' => date('Y-m-d H:i:s'),
            'id_tarif' => $id_tarif,
            'id_area' => $this->request->getPost('id_area'),
            'status' => 'masuk',
            'id_user' => session()->get('id_user')
        ];

        if (!$this->transaksiModel->save($data)) {
            session()->setFlashdata('error', 'Gagal menyimpan transaksi: ' . implode(', ', $this->transaksiModel->errors()));
            return redirect()->back()->withInput();
        }

        $id_transaksi = $this->transaksiModel->getInsertID();

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Transaksi masuk: ' . $plat_nomor . ' (' . $jenis_kendaraan . ')'
        );

        session()->setFlashdata('id_transaksi_terakhir', $id_transaksi);
        return redirect()->to('/transaksi')->with('success', 'Transaksi masuk berhasil dicatat');
    }

    public function cetakStrukMasuk($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $transaksi = $this->transaksiModel->getTransaksiWithRelations($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mencetak struk masuk: ' . $transaksi['plat_nomor']
        );

        $data = [
            'title' => 'Struk Masuk',
            'transaksi' => $transaksi
        ];

        return view('transaksi/struk_masuk', $data);
    }

    public function keluar()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mengakses halaman transaksi keluar'
        );

        $data = [
            'title' => 'Transaksi Keluar',
            'transaksi' => $this->transaksiModel->getTransaksiWithRelations(),
            'transaksi_selesai' => $this->transaksiModel->getTransaksiSelesai()
        ];

        return view('transaksi/keluar', $data);
    }

    public function processKeluar($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/keluar')->with('error', 'Transaksi tidak ditemukan');
        }

        $waktu_keluar = date('Y-m-d H:i:s');
        $metode_pembayaran = $this->request->getPost('metode_pembayaran');
        
        // Validasi metode pembayaran
        if (empty($metode_pembayaran)) {
            return redirect()->to('/transaksi/keluar')->with('error', 'Metode pembayaran harus dipilih');
        }
        
        // Ambil tarif untuk menghitung biaya
        $transaksiDetail = $this->transaksiModel->getTransaksiWithRelations($id);
        
        // Debug: Tampilkan data transaksi
        log_message('debug', 'Transaksi detail: ' . json_encode($transaksiDetail));
        
        if (!$transaksiDetail) {
            log_message('error', 'Transaksi not found');
            return redirect()->to('/transaksi/keluar')->with('error', 'Transaksi tidak ditemukan');
        }
        
        // Jika id_tarif tidak ada, cari tarif berdasarkan jenis kendaraan
        if (!isset($transaksiDetail['id_tarif']) || empty($transaksiDetail['id_tarif'])) {
            log_message('debug', 'id_tarif not found, searching by jenis_kendaraan: ' . $transaksiDetail['jenis_kendaraan']);
            $tarif = $this->tarifModel->where('jenis_kendaraan', $transaksiDetail['jenis_kendaraan'])->first();
            if ($tarif) {
                $transaksiDetail['id_tarif'] = $tarif['id_tarif'];
                $transaksiDetail['tarif_per_jam'] = $tarif['tarif_per_jam'];
                log_message('debug', 'Found tarif: ' . json_encode($tarif));
            } else {
                log_message('error', 'Tarif not found for jenis_kendaraan: ' . $transaksiDetail['jenis_kendaraan']);
                return redirect()->to('/transaksi/keluar')->with('error', 'Tarif tidak ditemukan untuk jenis kendaraan ini');
            }
        }
        
        // Update waktu keluar dengan id_tarif dan id_area yang benar
        $this->transaksiModel->transaksiKeluar($id, $waktu_keluar, $transaksiDetail['id_tarif'], $transaksiDetail['id_area']);
        
        // Update metode pembayaran
        $this->transaksiModel->update($id, ['metode_pembayaran' => $metode_pembayaran]);
        
        // Gunakan tarif tetap 1000 per jam
        $this->transaksiModel->updateWithBiaya($id, 1000);

        // Ambil data transaksi yang sudah diperbarui (setelah perhitungan biaya)
        $transaksiFinal = $this->transaksiModel->getTransaksiWithRelations($id);
        
        // Debug: Tampilkan data transaksi final
        log_message('debug', 'Transaksi final: ' . json_encode($transaksiFinal));

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Transaksi keluar: ' . $transaksiDetail['plat_nomor'] . ' (' . $metode_pembayaran . ') - Rp ' . number_format($transaksiFinal['biaya_total'] ?? 0, 0, ',', '.')
        );

        return redirect()->to('/transaksi/keluar')->with('success', 'Transaksi keluar berhasil diproses');
    }
public function realtime($id)
{
    $transaksi = $this->transaksiModel->find($id);
    if (!$transaksi) return $this->response->setJSON(['error' => 'not found']);

    $masuk = new \DateTime($transaksi['waktu_masuk']);
    $now = new \DateTime();

    $diff = $masuk->diff($now);

    $jam = ($diff->days * 24) + $diff->h;
    if ($diff->i > 0 || $diff->s > 0) $jam++;

    if ($jam < 1) $jam = 1;

    // tarif aturan kamu
    if ($jam <= 2)
        $biaya = 2000;
    else
        $biaya = 2000 + (($jam - 2) * 1000);

    return $this->response->setJSON([
        'durasi' => $jam,
        'biaya' => $biaya,
        'sekarang' => date('H:i:s')
    ]);
}
    public function cetakStruk($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $transaksi = $this->transaksiModel->getTransaksiWithRelations($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/keluar')->with('error', 'Transaksi tidak ditemukan');
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

    public function cetakStrukList()
    {
        $check = $this->checkRole();
        if ($check) return $check;

        // Log aktivitas
        $this->logModel->logActivity(
            session()->get('id_user'),
            'Mengakses halaman daftar struk'
        );

        // Ambil semua transaksi untuk debugging
        $allTransaksi = $this->transaksiModel->findAll();
        $selesaiTransaksi = $this->transaksiModel->getTransaksiSelesai();
        
        // Debug: Log jumlah transaksi
        log_message('debug', 'Total transaksi: ' . count($allTransaksi));
        log_message('debug', 'Transaksi selesai: ' . count($selesaiTransaksi));
        
        $data = [
            'title' => 'Daftar Struk',
            'transaksi' => $selesaiTransaksi,
            'all_transaksi' => $allTransaksi // Untuk debugging
        ];

        return view('transaksi/struk_list', $data);
    }

    // Method untuk rehit biaya berdasarkan durasi_jam yang ada di database
    public function rehitBiaya($id)
    {
        $check = $this->checkRole();
        if ($check) return $check;

        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/keluar')->with('error', 'Transaksi tidak ditemukan');
        }

        // Rehit biaya berdasarkan durasi_jam yang ada di database
        if ($this->transaksiModel->rehitBiayaFromDurasi($id)) {
            // Log aktivitas
            $this->logModel->logActivity(
                session()->get('id_user'),
                'Rehit biaya transaksi ID: ' . $id . ' (durasi: ' . $transaksi['durasi_jam'] . ' jam)'
            );

            return redirect()->to('/transaksi/keluar')->with('success', 'Biaya berhasil dihitung ulang');
        } else {
            return redirect()->to('/transaksi/keluar')->with('error', 'Gagal menghitung ulang biaya');
        }
    }
}
