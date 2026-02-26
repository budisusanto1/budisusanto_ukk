<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi extends Model
{
    protected $table            = 'tb_transaksi';
    protected $primaryKey       = 'id_parkir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kendaraan', 'waktu_masuk', 'waktu_keluar', 'id_tarif', 'durasi_jam', 'biaya_total', 'status', 'id_user', 'id_area', 'metode_pembayaran'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_kendaraan' => 'required|integer',
        'waktu_masuk' => 'required|valid_date[Y-m-d H:i:s]',
        'waktu_keluar' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'id_tarif' => 'permit_empty|integer',
        'durasi_jam' => 'permit_empty|numeric',
        'biaya_total' => 'permit_empty|numeric',
        'status' => 'required|in_list[masuk,keluar,selesai]',
        'id_user' => 'required|integer',
        'id_area' => 'permit_empty|integer',
        'metode_pembayaran' => 'permit_empty|in_list[tunai,transfer,ewallet,kartu_kredit,kartu_debit]'
    ];
    protected $validationMessages   = [
        'id_kendaraan' => [
            'required' => 'Kendaraan harus dipilih',
            'integer' => 'ID kendaraan harus angka'
        ],
        'waktu_masuk' => [
            'required' => 'Waktu masuk harus diisi',
            'valid_date' => 'Format waktu masuk tidak valid'
        ],
        'waktu_keluar' => [
            'valid_date' => 'Format waktu keluar tidak valid'
        ],
        'id_tarif' => [
            'integer' => 'ID tarif harus angka'
        ],
        'durasi_jam' => [
            'numeric' => 'Durasi harus angka'
        ],
        'biaya_total' => [
            'numeric' => 'Biaya total harus angka'
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status tidak valid'
        ],
        'id_user' => [
            'required' => 'User harus dipilih',
            'integer' => 'ID user harus angka'
        ],
        'id_area' => [
            'integer' => 'ID area harus angka'
        ],
        'metode_pembayaran' => [
            'in_list' => 'Metode pembayaran tidak valid'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Custom method untuk transaksi masuk
    public function transaksiMasuk($data)
    {
        $data['waktu_masuk'] = date('Y-m-d H:i:s');
        $data['status'] = 'masuk';
        $data['id_user'] = session()->get('id_user');
        
        return $this->save($data);
    }

    // Custom method untuk transaksi keluar
    public function transaksiKeluar($id_parkir, $waktu_keluar, $id_tarif = null, $id_area = null)
    {
        $transaksi = $this->find($id_parkir);
        if (!$transaksi) {
            return false;
        }

        $data = [
            'waktu_keluar' => $waktu_keluar,
            'status' => 'keluar',
            'id_tarif' => $id_tarif,
            'id_area' => $id_area
        ];

        return $this->update($id_parkir, $data);
    }

    // Custom method untuk update transaksi dengan perhitungan biaya
    public function updateWithBiaya($id_parkir, $tarif_per_jam)
    {
        $transaksi = $this->find($id_parkir);
        if (!$transaksi || !$transaksi['waktu_keluar']) {
            return false;
        }

        $waktu_masuk = new \DateTime($transaksi['waktu_masuk']);
        $waktu_keluar = new \DateTime($transaksi['waktu_keluar']);
        $interval = $waktu_masuk->diff($waktu_keluar);
        
        // Hitung durasi dalam jam (dengan pembulatan ke atas)
        $durasi_jam = $interval->h + ($interval->i / 60);
        $durasi_jam = ceil($durasi_jam * 100) / 100; // Pembulatan ke 2 desimal
        
        // Hitung biaya total
        $biaya_total = $durasi_jam * $tarif_per_jam;

        // Debug: Log perhitungan
        log_message('debug', "UpdateWithBiaya - ID: $id_parkir, Tarif: $tarif_per_jam");
        log_message('debug', "UpdateWithBiaya - Waktu Masuk: " . $transaksi['waktu_masuk']);
        log_message('debug', "UpdateWithBiaya - Waktu Keluar: " . $transaksi['waktu_keluar']);
        log_message('debug', "UpdateWithBiaya - Interval: " . $interval->format('%H:%I:%S'));
        log_message('debug', "UpdateWithBiaya - Durasi Jam: $durasi_jam");
        log_message('debug', "UpdateWithBiaya - Biaya Total: $biaya_total");

        $data = [
            'durasi_jam' => $durasi_jam,
            'biaya_total' => $biaya_total,
            'status' => 'selesai'
        ];

        // Pertahankan id_tarif dan metode_pembayaran jika sudah ada
        if (isset($transaksi['id_tarif'])) {
            $data['id_tarif'] = $transaksi['id_tarif'];
        }
        if (isset($transaksi['metode_pembayaran'])) {
            $data['metode_pembayaran'] = $transaksi['metode_pembayaran'];
        }

        return $this->update($id_parkir, $data);
    }

    // Custom method untuk menghitung durasi dan biaya
    public function hitungBiaya($id_parkir, $tarif_per_jam)
    {
        $transaksi = $this->find($id_parkir);
        if (!$transaksi || !$transaksi['waktu_keluar']) {
            return false;
        }

        $waktu_masuk = new \DateTime($transaksi['waktu_masuk']);
        $waktu_keluar = new \DateTime($transaksi['waktu_keluar']);
        $interval = $waktu_masuk->diff($waktu_keluar);
        
        // Hitung durasi dalam jam (dengan pembulatan ke atas)
        $durasi_jam = $interval->h + ($interval->i / 60);
        $durasi_jam = ceil($durasi_jam * 100) / 100; // Pembulatan ke 2 desimal
        
        // Hitung biaya total
        $biaya_total = $durasi_jam * $tarif_per_jam;

        $data = [
            'durasi_jam' => $durasi_jam,
            'biaya_total' => $biaya_total,
            'status' => 'selesai'
        ];

        // Pertahankan id_tarif dan metode_pembayaran jika sudah ada
        if (isset($transaksi['id_tarif'])) {
            $data['id_tarif'] = $transaksi['id_tarif'];
        }
        if (isset($transaksi['metode_pembayaran'])) {
            $data['metode_pembayaran'] = $transaksi['metode_pembayaran'];
        }

        return $this->update($id_parkir, $data);
    }

    // Custom method untuk mendapatkan transaksi dengan relasi
    public function getTransaksiWithRelations($id = null)
    {
        $this->select('tb_transaksi.*, tb_kendaraan.plat_nomor, tb_kendaraan.jenis_kendaraan, tb_kendaraan.warna, tb_kendaraan.pemilik, tb_user.username as petugas, tb_tarif.tarif_per_jam');
        $this->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_transaksi.id_kendaraan');
        $this->join('tb_user', 'tb_user.id_user = tb_transaksi.id_user');
        $this->join('tb_tarif', 'tb_tarif.id_tarif = tb_transaksi.id_tarif', 'left');
        
        if ($id !== null) {
            return $this->where('tb_transaksi.id_parkir', $id)->first();
        }
        
        return $this->findAll();
    }

    // Custom method untuk transaksi aktif (belum keluar)
    public function getTransaksiAktif()
    {
        return $this->where('status', 'masuk')->findAll();
    }

    // Custom method untuk transaksi selesai (sudah keluar dan dihitung)
    public function getTransaksiSelesai()
    {
        $this->select('tb_transaksi.*, tb_kendaraan.plat_nomor, tb_kendaraan.jenis_kendaraan, tb_kendaraan.warna, tb_kendaraan.pemilik, tb_user.username as petugas, tb_tarif.tarif_per_jam');
        $this->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_transaksi.id_kendaraan');
        $this->join('tb_user', 'tb_user.id_user = tb_transaksi.id_user');
        $this->join('tb_tarif', 'tb_tarif.id_tarif = tb_transaksi.id_tarif', 'left');
        
        return $this->groupStart()
                    ->where('tb_transaksi.status', 'selesai')
                    ->orWhere('tb_transaksi.status', 'keluar') // Juga ambil yang status keluar
                    ->groupEnd()
                    ->orderBy('tb_transaksi.waktu_keluar', 'DESC')
                    ->limit(50) // Batas 50 transaksi terakhir
                    ->findAll();
    }

    // Custom method untuk transaksi hari ini
    public function getTransaksiHariIni()
    {
        $today = date('Y-m-d');
        return $this->where("DATE(waktu_masuk) =", $today)->findAll();
    }

    // Custom method untuk rekap transaksi per tanggal
    public function getRekapByDate($tanggal_awal, $tanggal_akhir)
    {
        $this->select('tb_transaksi.*, tb_kendaraan.plat_nomor, tb_kendaraan.jenis_kendaraan, tb_user.username as petugas');
        $this->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan = tb_transaksi.id_kendaraan');
        $this->join('tb_user', 'tb_user.id_user = tb_transaksi.id_user');
        $this->where('tb_transaksi.waktu_masuk >=', $tanggal_awal . ' 00:00:00');
        $this->where('tb_transaksi.waktu_masuk <=', $tanggal_akhir . ' 23:59:59');
        $this->orderBy('tb_transaksi.waktu_masuk', 'DESC');
        
        return $this->findAll();
    }

    // Custom method untuk rekap transaksi per tanggal
    public function getRekapTransaksi($tanggal_awal, $tanggal_akhir)
    {
        return $this->where("DATE(waktu_masuk) >=", $tanggal_awal)
                    ->where("DATE(waktu_masuk) <=", $tanggal_akhir)
                    ->where('status', 'selesai')
                    ->findAll();
    }

    // Custom method untuk statistik pendapatan
    public function getStatistikPendapatan($tanggal_awal, $tanggal_akhir)
    {
        $this->select('DATE(waktu_masuk) as tanggal, COUNT(*) as jumlah_transaksi, SUM(biaya_total) as total_pendapatan');
        $this->where("DATE(waktu_masuk) >=", $tanggal_awal);
        $this->where("DATE(waktu_masuk) <=", $tanggal_akhir);
        $this->where('status', 'selesai');
        $this->groupBy('DATE(waktu_masuk)');
        
        return $this->findAll();
    }
}
