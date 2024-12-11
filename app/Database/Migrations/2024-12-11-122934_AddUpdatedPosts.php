<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedPosts extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addColumn('posts', [
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropColumn('posts', 'updated_at');
        $this->db->enableForeignKeyChecks();
    }
}
