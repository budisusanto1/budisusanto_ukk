<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaLengkapToTbUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_user', [
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'username'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_user', 'nama_lengkap');
    }
}
