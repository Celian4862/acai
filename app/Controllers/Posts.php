<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\PostsModel;
use App\Models\CommentsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Posts extends BaseController
{
    public function dashboard() {
        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            $model = model(PostsModel::class);
            $posts = $model->getUsersPosts(model(AccountsModel::class)->getAccount(session()->get('username'))['id']); // Get only posts made by the current user
            $data = session()->get();
            $data['posts'] = $posts;

            return view('components/header', ['title' => 'Dashboard'])
                . view('components/nav')
                . view('forum/dashboard', $data)
                . view('components/footer');
        }

        return redirect('Accounts::view');
    }

    public function view($page = 'index') {
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

    public function view_post($slug = false) {
        if (!$slug) {
            return redirect()->to('/dashboard');
        }
        $post = model(PostsModel::class)->getPosts($slug);
        $comments = model(CommentsModel::class)->getComments($post['id']);

        if (empty($post)) {
            throw new PageNotFoundException("Cannot find the post: {$slug}");
        }

        helper('form');
        return view('components/header', ['title' => $post['title']])
            . view('components/nav')
            . view('forum/post', ['post' => $post, 'comments' => $comments, 'op_name' => model(AccountsModel::class)->getAccountById($post['account_id'])['username']])
            . view('components/footer');
    }

    public function newpost() {
        helper(['form', 'url', 'date']);

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
            'updated_at' => date('Y-m-d H:i:s', now(app_timezone())),
        ]);

        return redirect()->to('/dashboard');
    }

    public function edit_post() {

    }
}