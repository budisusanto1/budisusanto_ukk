<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixLogAktivitasForeignKey extends Migration
{
    public function up()
    {
        // Hapus foreign key lama jika ada
        $db = \Config\Database::connect();
        
        // Cek nama foreign key
        $query = $db->query("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_log_aktivitas' 
            AND COLUMN_NAME = 'id_user' 
            AND REFERENCED_TABLE_NAME = 'tb_user'
        ");
        
        $result = $query->getRow();
        
        if ($result) {
            $foreignKeyName = $result->CONSTRAINT_NAME;
            $db->query("ALTER TABLE tb_log_aktivitas DROP FOREIGN KEY $foreignKeyName");
        }
        
        // Ubah id_user menjadi nullable
        $db->query("ALTER TABLE tb_log_aktivitas MODIFY id_user INT(11) UNSIGNED NULL");
        
        // Tambah foreign key baru dengan SET NULL
        $db->query("
            ALTER TABLE tb_log_aktivitas 
            ADD CONSTRAINT tb_log_aktivitas_id_user_foreign 
            FOREIGN KEY (id_user) REFERENCES tb_user(id_user) 
            ON DELETE SET NULL ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // Hapus foreign key
        $db = \Config\Database::connect();
        
        $query = $db->query("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_log_aktivitas' 
            AND COLUMN_NAME = 'id_user' 
            AND REFERENCED_TABLE_NAME = 'tb_user'
        ");
        
        $result = $query->getRow();
        
        if ($result) {
            $foreignKeyName = $result->CONSTRAINT_NAME;
            $db->query("ALTER TABLE tb_log_aktivitas DROP FOREIGN KEY $foreignKeyName");
        }
        
        // Ubah id_user menjadi NOT NULL
        $db->query("ALTER TABLE tb_log_aktivitas MODIFY id_user INT(11) UNSIGNED NOT NULL");
        
        // Tambah foreign key lama
        $db->query("
            ALTER TABLE tb_log_aktivitas 
            ADD CONSTRAINT tb_log_aktivitas_id_user_foreign 
            FOREIGN KEY (id_user) REFERENCES tb_user(id_user) 
            ON DELETE CASCADE ON UPDATE CASCADE
        ");
    }
}
