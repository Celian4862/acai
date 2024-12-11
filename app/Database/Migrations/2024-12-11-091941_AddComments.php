<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddComments extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'comment' => [
                'type' => 'TEXT',
            ],
            'post_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'account_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE');
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'CASCADE');
        $this->forge->createTable('comments');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('comments');
        $this->db->enableForeignKeyChecks();
    }
}
