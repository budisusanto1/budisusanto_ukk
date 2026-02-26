<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyTarifToTransaksi extends Migration
{
    public function up()
    {
        // Tambahkan foreign key untuk id_tarif
        $this->forge->addForeignKey(
            'id_tarif',           // foreign key
            'tb_tarif',           // reference table
            'id_tarif',           // reference column
            'CASCADE',            // on delete
            'CASCADE'             // on update
        );
    }

    public function down()
    {
        // Hapus foreign key id_tarif
        $this->forge->dropForeignKey('id_tarif', 'tb_tarif');
    }
}
