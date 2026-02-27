<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_parkir' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kendaraan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'waktu_masuk' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'waktu_keluar' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_tarif' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'durasi_jam' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default'    => 0,
            ],
            'biaya_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'default'    => 0,
            ],
            'status' => [
                'type'       => "ENUM('masuk','keluar','selesai')",
                'default'    => 'masuk',
                'null'       => false,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_area' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addKey('id_parkir', true);
        $this->forge->addForeignKey('id_kendaraan', 'tb_kendaraan', 'id_kendaraan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_transaksi');
    }
}
