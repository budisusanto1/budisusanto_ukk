<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitas extends Model
{
    protected $table            = 'tb_log_aktivitas';
    protected $primaryKey       = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'aktivitas', 'waktu_aktivitas', 'ip_address'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_user' => 'required|integer',
        'aktivitas' => 'required|max_length[255]',
        'waktu_aktivitas' => 'required|valid_date[Y-m-d H:i:s]',
        'ip_address' => 'max_length[45]'
    ];
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'User harus dipilih',
            'integer' => 'ID user harus angka'
        ],
        'aktivitas' => [
            'required' => 'Aktivitas harus diisi',
            'max_length' => 'Aktivitas maksimal 255 karakter'
        ],
        'waktu_aktivitas' => [
            'required' => 'Waktu aktivitas harus diisi',
            'valid_date' => 'Format waktu tidak valid'
        ],
        'ip_address' => [
            'max_length' => 'IP address maksimal 45 karakter'
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

    // Custom method untuk log aktivitas
    public function logActivity($id_user, $aktivitas, $ip_address = null)
    {
        // Ambil dari request jika tidak disediakan
        if ($ip_address === null) {
            try {
                $request = \Config\Services::request();
                $ip_address = $request->getIPAddress();
            } catch (\Exception $e) {
                // Fallback jika request tidak tersedia
                $ip_address = $ip_address ?? '127.0.0.1';
            }
        }

        $data = [
            'id_user' => $id_user,
            'aktivitas' => $aktivitas,
            'waktu_aktivitas' => date('Y-m-d H:i:s'),
            'ip_address' => $ip_address
        ];

        return $this->insert($data);
    }

    // Custom method untuk log login
    public function logLogin($id_user, $username = null)
    {
        $aktivitas = 'Login berhasil';
        if ($username) {
            $aktivitas .= ' (Username: ' . $username . ')';
        }
        
        return $this->logActivity($id_user, $aktivitas);
    }

    // Custom method untuk log logout
    public function logLogout($id_user)
    {
        return $this->logActivity($id_user, 'Logout');
    }

    // Custom method untuk log register
    public function logRegister($id_user, $username)
    {
        return $this->logActivity($id_user, 'Register user baru (Username: ' . $username . ')');
    }

    // Custom method untuk log CRUD operations
    public function logCRUD($id_user, $action, $module, $details = null)
    {
        $aktivitas = ucfirst($action) . ' ' . $module;
        if ($details) {
            $aktivitas .= ' - ' . $details;
        }
        
        return $this->logActivity($id_user, $aktivitas);
    }

    // Custom method untuk log transaksi
    public function logTransaksi($id_user, $jenis_transaksi, $details = null)
    {
        $aktivitas = 'Transaksi ' . $jenis_transaksi;
        if ($details) {
            $aktivitas .= ' - ' . $details;
        }
        
        return $this->logActivity($id_user, $aktivitas);
    }

    // Custom method untuk mendapatkan log dengan user info
    public function getLogsWithUser($limit = 100, $offset = 0)
    {
        try {
            $this->select('tb_log_aktivitas.*, tb_user.username, tb_user.nama_lengkap');
            $this->join('tb_user', 'tb_user.id_user = tb_log_aktivitas.id_user', 'left');
            $this->orderBy('tb_log_aktivitas.waktu_aktivitas', 'DESC');
            
            if ($limit > 0) {
                $this->limit($limit, $offset);
            }
            
            $result = $this->findAll();
            
            // Debug: Log query result
            log_message('debug', 'LogAktivitas - getLogsWithUser result count: ' . count($result));
            
            return $result;
        } catch (\Exception $e) {
            // Debug: Log error
            log_message('error', 'LogAktivitas - getLogsWithUser error: ' . $e->getMessage());
            
            // Fallback: Return all logs without join
            return $this->orderBy('waktu_aktivitas', 'DESC')->findAll();
        }
    }

    // Custom method untuk mendapatkan log berdasarkan user
    public function getLogsByUser($id_user, $limit = 50)
    {
        return $this->where('id_user', $id_user)
                    ->orderBy('waktu_aktivitas', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    // Custom method untuk mendapatkan log hari ini
    public function getLogsToday()
    {
        $today = date('Y-m-d');
        return $this->where("DATE(waktu_aktivitas) =", $today)
                    ->orderBy('waktu_aktivitas', 'DESC')
                    ->findAll();
    }

    // Custom method untuk mendapatkan log berdasarkan tanggal range
    public function getLogsByDateRange($tanggal_awal, $tanggal_akhir)
    {
        return $this->where("DATE(waktu_aktivitas) >=", $tanggal_awal)
                    ->where("DATE(waktu_aktivitas) <=", $tanggal_akhir)
                    ->orderBy('waktu_aktivitas', 'DESC')
                    ->findAll();
    }

    // Custom method untuk search log
    public function searchLogs($keyword)
    {
        try {
            $this->select('tb_log_aktivitas.*, tb_user.username, tb_user.nama_lengkap');
            $this->join('tb_user', 'tb_user.id_user = tb_log_aktivitas.id_user', 'left');
            
            $this->groupStart()
                    ->like('tb_log_aktivitas.aktivitas', $keyword)
                    ->orLike('tb_user.username', $keyword)
                    ->orLike('tb_user.nama_lengkap', $keyword)
                    ->orLike('tb_log_aktivitas.ip_address', $keyword)
                    ->groupEnd();
            
            $this->orderBy('tb_log_aktivitas.waktu_aktivitas', 'DESC');
            
            $result = $this->findAll();
            
            // Debug: Log search result
            log_message('debug', 'LogAktivitas - searchLogs result count: ' . count($result) . ' for keyword: ' . $keyword);
            
            return $result;
        } catch (\Exception $e) {
            // Debug: Log error
            log_message('error', 'LogAktivitas - searchLogs error: ' . $e->getMessage());
            
            // Fallback: Simple search
            return $this->like('aktivitas', $keyword)
                        ->orderBy('waktu_aktivitas', 'DESC')
                        ->findAll();
        }
    }

    // Custom method untuk statistik aktivitas
    public function getAktivitasStats($tanggal_awal, $tanggal_akhir)
    {
        $this->select('DATE(waktu_aktivitas) as tanggal, COUNT(*) as total_aktivitas');
        $this->where("DATE(waktu_aktivitas) >=", $tanggal_awal);
        $this->where("DATE(waktu_aktivitas) <=", $tanggal_akhir);
        $this->groupBy('DATE(waktu_aktivitas)');
        $this->orderBy('tanggal', 'ASC');
        
        return $this->findAll();
    }

    // Custom method untuk cleanup log lama
    public function cleanOldLogs($days_old = 90)
    {
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$days_old} days"));
        
        return $this->where('waktu_aktivitas <', $cutoff_date)->delete();
    }
}
