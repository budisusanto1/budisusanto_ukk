<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyAreaToTransaksi extends Migration
{
    public function up()
    {
        // Tambahkan foreign key untuk id_area
        $this->forge->addForeignKey(
            'id_area',            // foreign key
            'tb_area_parkir',     // reference table
            'id_area',            // reference column
            'CASCADE',            // on delete
            'CASCADE'             // on update
        );
    }

    public function down()
    {
        // Hapus foreign key id_area
        $this->forge->dropForeignKey('id_area', 'tb_area_parkir');
    }
}
