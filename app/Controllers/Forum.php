<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ForumModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Forum extends BaseController
{
public function view($page = 'dashboard') {
  if (!is_file(APPPATH.'/Views/forum/'.$page.'.php')) {
    throw new PageNotFoundException($page);
  }

  if (session()->has('logged_in') && session()->get('logged_in') === true) {
    $seeder = \Config\Database::seeder();
    $seeder->call('PostsTable');
    
    $model = model(ForumModel::class);
    $posts = $model->getPosts();
    $data = session()->get();
    $data['posts'] = $posts;

    return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
      . view('components/nav')
      . view('forum/' . $page, $data)
      . view('templates/footer');
    }
  
    return redirect('Accounts::view');
  }
}