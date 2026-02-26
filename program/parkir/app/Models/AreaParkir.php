<?php

namespace App\Models;

use CodeIgniter\Model;

class AreaParkir extends Model
{
    protected $table            = 'tb_area_parkir';
    protected $primaryKey       = 'id_area';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_area', 'kapasitas', 'terisi'];

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

    // Override save method untuk debugging
    public function save($data = null): bool
    {
        // Debug: Tampilkan data yang akan disimpan
        log_message('debug', 'AreaParkir Model - Save data: ' . json_encode($data));
        
        $result = parent::save($data);
        
        // Debug: Tampilkan hasil
        log_message('debug', 'AreaParkir Model - Save result: ' . ($result ? 'SUCCESS' : 'FAILED'));
        
        if (!$result) {
            log_message('error', 'AreaParkir Model - Errors: ' . json_encode($this->errors()));
        }
        
        return $result;
    }

    // Validation
    protected $validationRules      = [
        'nama_area' => 'required|max_length[100]',
        'kapasitas' => 'required|integer|greater_than_equal_to[0]',
        'terisi' => 'required|integer|greater_than_equal_to[0]'
    ];
    protected $validationMessages   = [
        'nama_area' => [
            'required' => 'Nama area harus diisi',
            'max_length' => 'Nama area maksimal 100 karakter'
        ],
        'kapasitas' => [
            'required' => 'Kapasitas harus diisi',
            'integer' => 'Kapasitas harus angka',
            'greater_than_equal_to' => 'Kapasitas tidak boleh kurang dari 0'
        ],
        'terisi' => [
            'required' => 'Terisi harus diisi',
            'integer' => 'Terisi harus angka',
            'greater_than_equal_to' => 'Terisi tidak boleh kurang dari 0'
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

    // Custom method untuk mendapatkan semua area
    public function getAllAreas()
    {
        return $this->orderBy('nama_area', 'ASC')->findAll();
    }

    // Custom method untuk mendapatkan area berdasarkan ID
    public function getAreaById($id_area)
    {
        return $this->find($id_area);
    }

    // Custom method untuk menambah area baru
    public function tambahArea($nama_area, $kapasitas)
    {
        $data = [
            'nama_area' => $nama_area,
            'kapasitas' => $kapasitas,
            'terisi' => 0
        ];
        
        return $this->insert($data);
    }

    // Custom method untuk update kapasitas area
    public function updateKapasitas($id_area, $kapasitas_baru)
    {
        return $this->update($id_area, ['kapasitas' => $kapasitas_baru]);
    }

    // Custom method untuk update terisi area
    public function updateTerisi($id_area, $terisi_baru)
    {
        return $this->update($id_area, ['terisi' => $terisi_baru]);
    }

    // Custom method untuk menambah/mengurangi terisi
    public function tambahTerisi($id_area, $jumlah = 1)
    {
        $area = $this->find($id_area);
        if (!$area) {
            return false;
        }
        
        $terisi_baru = $area['terisi'] + $jumlah;
        
        // Pastikan tidak melebihi kapasitas
        if ($terisi_baru > $area['kapasitas']) {
            $terisi_baru = $area['kapasitas'];
        }
        
        return $this->update($id_area, ['terisi' => $terisi_baru]);
    }

    // Custom method untuk mengurangi terisi
    public function kurangiTerisi($id_area, $jumlah = 1)
    {
        $area = $this->find($id_area);
        if (!$area) {
            return false;
        }
        
        $terisi_baru = $area['terisi'] - $jumlah;
        
        // Pastikan tidak kurang dari 0
        if ($terisi_baru < 0) {
            $terisi_baru = 0;
        }
        
        return $this->update($id_area, ['terisi' => $terisi_baru]);
    }

    // Custom method untuk mendapatkan area yang tersedia
    public function getAreaTersedia()
    {
        return $this->where('terisi < kapasitas')->findAll();
    }

    // Custom method untuk mendapatkan area yang penuh
    public function getAreaPenuh()
    {
        return $this->where('terisi >= kapasitas')->findAll();
    }

    // Custom method untuk mendapatkan statistik area
    public function getStatistikArea()
    {
        $total_area = $this->countAllResults();
        $total_kapasitas = $this->selectSum('kapasitas')->first()['kapasitas'] ?? 0;
        $total_terisi = $this->selectSum('terisi')->first()['terisi'] ?? 0;
        
        return [
            'total_area' => $total_area,
            'total_kapasitas' => $total_kapasitas,
            'total_terisi' => $total_terisi,
            'tersedia' => $total_kapasitas - $total_terisi,
            'persentase_terisi' => $total_kapasitas > 0 ? round(($total_terisi / $total_kapasitas) * 100, 2) : 0
        ];
    }

    // Custom method untuk search area
    public function searchArea($keyword)
    {
        return $this->like('nama_area', $keyword)
                    ->orderBy('nama_area', 'ASC')
                    ->findAll();
    }

    // Custom method untuk cek kapasitas tersedia
    public function cekKapasitas($id_area, $jumlah_dibutuhkan = 1)
    {
        $area = $this->find($id_area);
        if (!$area) {
            return [
                'available' => false,
                'message' => 'Area tidak ditemukan'
            ];
        }
        
        $tersedia = $area['kapasitas'] - $area['terisi'];
        
        if ($tersedia >= $jumlah_dibutuhkan) {
            return [
                'available' => true,
                'tersedia' => $tersedia,
                'message' => 'Kapasitas tersedia'
            ];
        } else {
            return [
                'available' => false,
                'tersedia' => $tersedia,
                'message' => 'Kapasitas tidak mencukupup. Tersedia: ' . $tersedia
            ];
        }
    }

    // Custom method untuk inisialisasi area default
    public function initializeDefaultAreas()
    {
        $default_areas = [
            ['nama_area' => 'Area A - Mobil', 'kapasitas' => 50],
            ['nama_area' => 'Area B - Motor', 'kapasitas' => 100],
            ['nama_area' => 'Area C - Bus/Truk', 'kapasitas' => 20],
            ['nama_area' => 'Area D - VIP', 'kapasitas' => 10]
        ];

        foreach ($default_areas as $area) {
            if (!$this->where('nama_area', $area['nama_area'])->first()) {
                $this->insert([
                    'nama_area' => $area['nama_area'],
                    'kapasitas' => $area['kapasitas'],
                    'terisi' => 0
                ]);
            }
        }
    }

    // Custom method untuk mendapatkan persentase keterisian
    public function getPersentaseKeterisian($id_area)
    {
        $area = $this->find($id_area);
        if (!$area) {
            return 0;
        }
        
        if ($area['kapasitas'] == 0) {
            return 0;
        }
        
        return round(($area['terisi'] / $area['kapasitas']) * 100, 2);
    }
}
