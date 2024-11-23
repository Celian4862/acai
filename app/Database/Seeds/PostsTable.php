<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PostsTable extends Seeder
{
  public function run()
  {
    $this->db->query('CREATE TABLE IF NOT EXISTS posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      slug VARCHAR(255) NOT NULL,
      body TEXT NOT NULL
    );');
  }
}