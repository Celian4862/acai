<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GhostAccount extends Migration
{
    public function up()
    {
        $seeder = \Config\Database::seeder();
        $seeder->call('GhostSeeder');
    }

    public function down()
    {
        $this->db->table('accounts')->delete(['email' => 'ghost@acai.com']);
    }
}
