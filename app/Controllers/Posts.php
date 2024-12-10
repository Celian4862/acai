<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Posts extends BaseController
{
    public function view($page = 'dashboard') {
        if (!is_file(APPPATH.'/Views/forum/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            $model = model(PostsModel::class);
            $posts = $model->getPosts();
            $data = session()->get();
            $data['posts'] = $posts;

        return view('components/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('forum/' . $page, $data)
            . view('components/footer');
        }

        return redirect('Accounts::view');
    }

    public function newpost() {
        
    }
}