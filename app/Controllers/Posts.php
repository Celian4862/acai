<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
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
        helper(['form', 'url']);

        $data = $this->request->getPost(['title', 'body']);

        if (! $this->validateData($data, [
            'title' => [
                'label' => 'Title',
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => '{field} is required',
                    'min_length' => '{field} must be at least {param} characters',
                    'max_length' => '{field} cannot exceed {param} characters'
                ]
            ],
            'body' => [
                'label' => 'Body',
                'rules' => 'required|min_length[3]|max_length[1000]',
                'errors' => [
                    'required' => '{field} is required',
                    'min_length' => '{field} must be at least {param} characters',
                    'max_length' => '{field} cannot exceed {param} characters'
                ]
            ],
        ])) {
            return redirect()->back()->withInput();
        }

        $files = $this->request->getFiles();

        if ($files) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $file->move(WRITEPATH . 'uploads');
                }
            }
        }

        $post = $this->validator->getValidated();

        $model = model(PostsModel::class);
        
        $model->save([
            'title' => $post['title'],
            'body' => $post['body'],
            'slug' => url_title(strtolower($post['title'])),
            'account_id' => model(AccountsModel::class)->getAccount(session()->get('username'))['id'],
        ]);

        return redirect()->to('/dashboard');
    }
}