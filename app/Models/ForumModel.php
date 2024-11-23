<?php

namespace App\Models;

use CodeIgniter\Model;

class ForumModel extends Model
{
  protected $table = 'posts';

  protected $allowedFields = ['title', 'slug', 'body'];

  public function getPosts($slug = false)
  {
    // Will need to add a method later on that shows only the posts that the user has created, specifically for the dashboard page.
    if ($slug === false) {
      return $this->findAll();
    }

    return $this->asArray()
      ->where(['slug' => $slug])
      ->first();
  }
}