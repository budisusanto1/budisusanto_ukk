<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbTarifTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tarif' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_kendaraan' => [
                'type'       => "ENUM('mobil','motor','truk','bus','lainnya')",
                'null'       => false,
            ],
            'tarif_per_jam' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'default'    => 0.00,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_tarif', true);
        $this->forge->addUniqueKey(['jenis_kendaraan'], 'unique_jenis_kendaraan');
        $this->forge->createTable('tb_tarif');
    }

    public function down()
    {
        $this->forge->dropTable('tb_tarif');
    }
}
