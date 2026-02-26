<?php

namespace App\Models;

use CodeIgniter\Model;

class Tarif extends Model
{
    protected $table            = 'tb_tarif';
    protected $primaryKey       = 'id_tarif';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['jenis_kendaraan', 'tarif_per_jam'];

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
        'jenis_kendaraan' => 'required|in_list[mobil,motor,truk,bus,lainnya]',
        'tarif_per_jam' => 'required|numeric|greater_than_equal_to[0]'
    ];
    protected $validationMessages   = [
        'jenis_kendaraan' => [
            'required' => 'Jenis kendaraan harus dipilih',
            'in_list' => 'Jenis kendaraan tidak valid'
        ],
        'tarif_per_jam' => [
            'required' => 'Tarif per jam harus diisi',
            'numeric' => 'Tarif harus angka',
            'greater_than_equal_to' => 'Tarif tidak boleh kurang dari 0'
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

    // Custom method untuk mendapatkan tarif berdasarkan jenis kendaraan
    public function getTarifByJenis($jenis_kendaraan)
    {
        return $this->where('jenis_kendaraan', $jenis_kendaraan)->first();
    }

    // Custom method untuk mendapatkan semua tarif
    public function getAllTarif()
    {
        return $this->findAll();
    }

    // Custom method untuk update tarif
    public function updateTarif($jenis_kendaraan, $tarif_baru)
    {
        return $this->where('jenis_kendaraan', $jenis_kendaraan)
                    ->set(['tarif_per_jam' => $tarif_baru])
                    ->update();
    }

    // Custom method untuk mendapatkan tarif dalam format array
    public function getTarifArray()
    {
        $tarifs = $this->findAll();
        $result = [];
        
        foreach ($tarifs as $tarif) {
            $result[$tarif['jenis_kendaraan']] = $tarif['tarif_per_jam'];
        }
        
        return $result;
    }

    // Custom method untuk cek apakah tarif sudah ada
    public function isTarifExist($jenis_kendaraan, $excludeId = null)
    {
        $query = $this->where('jenis_kendaraan', $jenis_kendaraan);
        
        // Jika sedang update, exclude record yang sedang diedit
        if ($excludeId !== null) {
            $query = $query->where('id_tarif !=', $excludeId);
        }
        
        return $query->countAllResults() > 0;
    }

    // Custom method untuk inisialisasi tarif default
    public function initializeDefaultTarif()
    {
        $default_tarif = [
            ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000],
            ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000],
            ['jenis_kendaraan' => 'truk', 'tarif_per_jam' => 10000],
            ['jenis_kendaraan' => 'bus', 'tarif_per_jam' => 15000],
            ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 3000]
        ];

        foreach ($default_tarif as $tarif) {
            if (!$this->isTarifExist($tarif['jenis_kendaraan'])) {
                $this->insert($tarif);
            }
        }
    }

    // Custom method untuk validasi tarif sebelum transaksi
    public function validateTarif($jenis_kendaraan)
    {
        $tarif = $this->getTarifByJenis($jenis_kendaraan);
        
        if (!$tarif) {
            return [
                'success' => false,
                'message' => 'Tarif untuk ' . $jenis_kendaraan . ' tidak ditemukan'
            ];
        }
        
        if ($tarif['tarif_per_jam'] <= 0) {
            return [
                'success' => false,
                'message' => 'Tarif untuk ' . $jenis_kendaraan . ' belum diatur'
            ];
        }
        
        return [
            'success' => true,
            'tarif' => $tarif['tarif_per_jam']
        ];
    }
}
