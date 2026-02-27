<?php

namespace App\Models;

use CodeIgniter\Model;

class Kendaraan extends Model
{
    protected $table            = 'tb_kendaraan';
    protected $primaryKey       = 'id_kendaraan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['plat_nomor', 'jenis_kendaraan', 'warna', 'pemilik', 'id_user'];

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
        'plat_nomor' => 'required|min_length[3]|max_length[20]',
        'jenis_kendaraan' => 'required|in_list[mobil,motor,truk,bus,lainnya]',
        'warna' => 'max_length[50]',
        'pemilik' => 'max_length[100]',
        'id_user' => 'required|integer'
    ];
    protected $validationMessages   = [
        'plat_nomor' => [
            'required' => 'Plat nomor harus diisi',
            'min_length' => 'Plat nomor minimal 3 karakter',
            'max_length' => 'Plat nomor maksimal 20 karakter'
        ],
        'jenis_kendaraan' => [
            'required' => 'Jenis kendaraan harus dipilih',
            'in_list' => 'Jenis kendaraan tidak valid'
        ],
        'warna' => [
            'max_length' => 'Warna maksimal 50 karakter'
        ],
        'pemilik' => [
            'max_length' => 'Pemilik maksimal 100 karakter'
        ],
        'id_user' => [
            'required' => 'User harus dipilih',
            'integer' => 'ID user harus angka'
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

    // Custom method untuk mendapatkan kendaraan dengan user
    public function getKendaraanWithUser($id = null)
    {
        $this->select('tb_kendaraan.*, tb_user.username, tb_user.nama_lengkap');
        $this->join('tb_user', 'tb_user.id_user = tb_kendaraan.id_user');
        
        if ($id !== null) {
            return $this->where('tb_kendaraan.id_kendaraan', $id)->first();
        }
        
        return $this->findAll();
    }

    // Custom method untuk kendaraan berdasarkan user
    public function getKendaraanByUser($userId)
    {
        return $this->where('id_user', $userId)->findAll();
    }

    // Custom method untuk search kendaraan
    public function searchKendaraan($keyword)
    {
        return $this->groupStart()
                    ->like('plat_nomor', $keyword)
                    ->orLike('pemilik', $keyword)
                    ->orLike('warna', $keyword)
                    ->groupEnd()
                    ->findAll();
    }
}
