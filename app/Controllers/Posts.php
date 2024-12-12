<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\PostsModel;
use App\Models\CommentsModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Exceptions\PageNotFoundException;

class Posts extends BaseController
{
    public function index() {
        $model = model(PostsModel::class);
        $posts = $model->getPosts();
        $data = session()->get();
        $data['posts'] = $posts;

        return view('components/header', ['title' => 'Forum'])
            . view('components/nav')
            . view('forum/index', $data)
            . view('components/footer');
    }

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

    public function view($page) {
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

    public function view_post($post_id) {
        $post = model(PostsModel::class)->getPosts($post_id);
        $time = new Time($post['updated_at']);
        $time = $time->difference(Time::now());
        if (($diff = $time->getSeconds()) < 60) {
            $post['updated_at'] = ($diff == 1) ? "{$diff} second ago" : "{$diff} seconds ago";
        } else if (($diff = $time->getMinutes()) < 60) {
            $post['updated_at'] = ($diff == 1) ? "{$diff} minute ago" : "{$diff} minutes ago";
        } elseif (($diff = $time->getHours()) < 24) {
            $post['updated_at'] = ($diff == 1) ? "{$diff} hour ago" : "{$diff} hours ago";
        } else if ($time->getMonths() == 0) {
            $diff = $time->getDays();
            $post['updated_at'] = ($diff == 1) ? "{$diff} day ago" : "{$diff} days ago";
        } else if (($diff = $time->getMonths()) < 12) {
            $post['updated_at'] = ($diff == 1) ? "{$diff} month ago" : "{$diff} months ago";
        } else {
            $post['updated_at'] = (($diff = $time->getYears()) == 1) ? "{$diff} year ago" : "{$diff} years ago";
        }

        $comments = model(CommentsModel::class)->getComments($post['id']);
        $accounts_model = model(AccountsModel::class);
        foreach ($comments as &$comment) {
            // Inserts a username key into the every sub-array in $comments
            $comment['username'] = $accounts_model->getAccountById($comment['account_id'])['username'];

            // Formats the updated_at key into a duration instead of a timestamp
            $time = new Time($comment['updated_at']);
            $time = $time->difference(Time::now());
            if (($diff = $time->getSeconds()) < 60) {
                $comment['updated_at'] = ($diff == 1) ? "{$diff} second ago" : "{$diff} seconds ago";
            } else if (($diff = $time->getMinutes()) < 60) {
                $comment['updated_at'] = ($diff == 1) ? "{$diff} minute ago" : "{$diff} minutes ago";
            } elseif (($diff = $time->getHours()) < 24) {
                $comment['updated_at'] = ($diff == 1) ? "{$diff} hour ago" : "{$diff} hours ago";
            } else if ($time->getMonths() == 0) {
                $diff = $time->getDays();
                $comment['updated_at'] = ($diff == 1) ? "{$diff} day ago" : "{$diff} days ago";
            } else if (($diff = $time->getMonths()) < 12) {
                $comment['updated_at'] = ($diff == 1) ? "{$diff} month ago" : "{$diff} months ago";
            } else {
                $comment['updated_at'] = (($diff = $time->getYears()) == 1) ? "{$diff} year ago" : "{$diff} years ago";
            }
        }

        if (empty($post)) {
            throw new PageNotFoundException("Cannot find post {$post_id}");
        }

        helper('form');
        return view('components/header', ['title' => $post['title']])
            . view('components/nav')
            . view('forum/post', ['post' => $post, 'comments' => $comments, 'op_name' => $accounts_model->getAccountById($post['account_id'])['username']])
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
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if ($files) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    if (in_array($file->getMimeType(), $allowedTypes)) {
                        $file->move(WRITEPATH . 'uploads');
                    } else {
                        $this->validateData([], [
                            'default' => [
                                'rules' => 'required',
                                'errors' => [
                                    'required' => 'Invalid file type: ' . $file->getClientName(),
                                ]
                            ]
                        ]);
                        return redirect()->back()->withInput();
                    }
                }
            }
        }

        $post = $this->validator->getValidated();

        $model = model(PostsModel::class);

        $model->save([
            'title' => $post['title'],
            'body' => $post['body'],
            'account_id' => model(AccountsModel::class)->getAccount(session()->get('username'))['id'],
            'updated_at' => date('Y-m-d H:i:s', now(app_timezone())),
        ]);

        return redirect()->to('/dashboard');
    }

    public function edit_post() {

    }
}