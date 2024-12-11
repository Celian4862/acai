<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPosts1 extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addColumn('posts', [
            'account_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'CASCADE', '', 'fk_account');
        $this->forge->processIndexes('posts');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropColumn('posts', 'account_id');
        $this->db->enableForeignKeyChecks();
    }
}
