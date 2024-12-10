<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GhostSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('accounts')->insert([
            'email' => 'ghost@acai.com',
            'username' => 'deleted_account',
            'birthdate' => '2000-01-01',
            'password' => password_hash(env('ghost.password'), PASSWORD_DEFAULT),
        ]);
    }
}
