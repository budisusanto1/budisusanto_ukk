<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetodePembayaranToTbTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_transaksi', [
            'metode_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['tunai', 'transfer', 'ewallet', 'kartu_kredit', 'kartu_debit'],
                'null' => true,
                'after' => 'biaya_total'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_transaksi', 'metode_pembayaran');
    }
}
