<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumModel extends Model
{
  protected $table = 'posts';

  protected $allowedFields = ['title', 'slug', 'body'];

  public function getPosts($slug = false)
  {
    if ($slug === false) {
      return $this->findAll();
    }

    return $this->asArray()
      ->where(['slug' => $slug])
      ->first();
  }
}