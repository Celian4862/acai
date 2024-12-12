<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImages extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'post_id' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE');
        $this->forge->createTable('images');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('images');
        $this->db->enableForeignKeyChecks();
    }
}
