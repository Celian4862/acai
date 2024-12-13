<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\PostsModel;
use App\Models\CommentsModel;
use App\Models\ImagesModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\Files\FileCollection;

class Posts extends BaseController
{
    /**
     * Displays the forum. Needs to be separate from view() in order to display for guests as well.
     * @return string
     */
    public function index() {
        $model = model(PostsModel::class);
        $posts = $model->getPosts();
        $data['posts'] = $posts;
        $data['id'] = model(AccountsModel::class)->getAccount(session()->get('username'))['id'] ?? null;

        helper('form');
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

            helper('form');
            return view('components/header', ['title' => 'Dashboard'])
                . view('components/nav')
                . view('forum/dashboard', $data)
                . view('components/footer');
        }

        return redirect('Accounts::view');
    }

    public function view($page) {
        if ($page === 'index') {
            return redirect()->to('/forum');
        }

        if ($page === 'dashboard') {
            return redirect()->to('/dashboard');
        }

        if (!is_file(APPPATH.'/Views/forum/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            $model = model(PostsModel::class);
            $posts = $model->getPosts();

            return view('components/header', ['title' => ucwords(str_replace('-', ' ', $page))])
                . view('components/nav')
                . view('forum/' . $page, ['posts' => $posts])
                . view('components/footer');
        }

        return redirect('Accounts::view');
    }

    /**
     * Renders the full view of every post in the forum
     * @param mixed $post_id
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     * @return string
     */
    public function view_post($post_id) {
        $post = model(PostsModel::class)->getPosts($post_id);

        if (empty($post)) {
            throw new PageNotFoundException("Cannot find post {$post_id}");
        }

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

        $image_refs = model(ImagesModel::class)->getImages($post_id);
        $images = [];

        foreach ($image_refs as $image) {
            $images[] = $image['image'];
        }

        helper('form');
        return view('components/header', ['title' => $post['title']])
            . view('components/nav')
            . view('forum/post', [
                'post' => $post,
                'comments' => $comments,
                'images' => $images,
                'op_name' => $accounts_model->getAccountById($post['account_id'])['username'],
                'id' => $accounts_model->getAccount(session()->get('username'))['id'] ?? null,
            ])
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
                    if (! in_array($file->getMimeType(), $allowedTypes)) {
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

        $posts_model = model(PostsModel::class);
        $images_model = model(ImagesModel::class);

        $posts_model->save([
            'title' => $post['title'],
            'body' => $post['body'],
            'account_id' => model(AccountsModel::class)->getAccount(session()->get('username'))['id'],
            'updated_at' => date('Y-m-d H:i:s', now(app_timezone())),
        ]);

        $new_post_id = $posts_model->insertID(); // To keep constant

        if ($files) {
            foreach ($files['images'] as $file) {
                $newName = $file->getRandomName();
                $images_model->save([
                    'post_id' => $new_post_id,
                    'image' => $newName,
                ]);
                $file->move(ROOTPATH . 'public/images/user_imgs', $newName);
            }
        }
        return redirect()->to("/forum/posts/{$new_post_id}");
    }

    /**
     * Renders the view for the edit-post page
     * @param mixed $post_id
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function edit($post_id) {
        if (!session()->has('logged_in') || session()->get('logged_in') !== true) {
            return redirect()->to('/login');
        }

        $post = model(PostsModel::class)->getPosts($post_id);
        if (model(AccountsModel::class)->getAccount(session()->get('username'))['id'] !== $post['account_id']) {
            return redirect()->to('/forum');
        }

        if (empty($post)) {
            throw new PageNotFoundException("Cannot find post {$post_id}");
        }

        return view('components/header', ['title' => 'Edit Post'])
            . view('components/nav')
            . view('forum/edit_post', [
                'post' => $post,
            ])
            . view('components/footer');

        // Will not deal with editing images for now
    }

    public function edit_post($post_id) {
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

        // Will not deal with editing images for now

        $post = $this->validator->getValidated();

        $posts_model = model(PostsModel::class);

        $posts_model->save([
            'id' => $post_id,
            'title' => $post['title'],
            'body' => $post['body'],
            'updated_at' => date('Y-m-d H:i:s', now()),
        ]);

        return redirect()->to("/forum/posts/{$post_id}");
    }

    public function delete_post($post_id) {
        $comments_model = model(CommentsModel::class);
        $images_model = model(ImagesModel::class);
        $posts_model = model(PostsModel::class);

        $comments = $comments_model->getComments($post_id);
        $images = $images_model->getImages($post_id);
        $post = $posts_model->getPosts($post_id);

        helper('filesystem');
        foreach ($images as $image) {
            $file = new \CodeIgniter\Files\File(ROOTPATH . 'public/images/user_imgs/' . $image['image']);
            $file->move(ROOTPATH . 'public/images/user_imgs/to-delete');
            $images_model->delete($image['id']);
        }
        delete_files(ROOTPATH . 'public/images/user_imgs/to-delete');

        foreach ($comments as $comment) {
            $comments_model->delete($comment['id']);
        }

        $posts_model->delete($post_id);

        return redirect()->to((session()->get('_ci_previous_url') === site_url('/dashboard')) ? '/dashboard' : '/forum');
    }
}