<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GhostAccount extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $seeder = \Config\Database::seeder();
        $seeder->call('GhostSeeder');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->db->table('accounts')->delete(['email' => 'ghost@acai.com']);
        $this->db->enableForeignKeyChecks();
    }
}
