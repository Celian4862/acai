<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveSlug extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropColumn('posts', 'slug');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addColumn('posts', [
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
        ]);
        $this->db->enableForeignKeyChecks();
    }
}
