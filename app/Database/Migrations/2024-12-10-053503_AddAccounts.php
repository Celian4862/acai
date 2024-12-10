<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccounts extends Migration
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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 254,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'birthdate' => [
                'type' => 'DATE',
            ],
            'reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'token_expiry' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('accounts');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('accounts');
    }
}
