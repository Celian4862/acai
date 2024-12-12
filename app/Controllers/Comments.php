<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccountsModel;
use App\Models\CommentsModel;
use CodeIgniter\HTTP\ResponseInterface;

class Comments extends BaseController
{
    public function add_comment($post_id)
    {
        helper(['form', 'date']);
        $data = $this->request->getPost(['comment']);
        if (! $this->validateData($data, [
            'comment' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Please enter a comment.',
                    'max_length' => 'Your comment is too long. Please keep it under {param} characters.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $form_data = $this->validator->getValidated();

        $model = model(CommentsModel::class);

        $model->save([
            'comment' => $form_data['comment'],
            'post_id' => $post_id,
            'account_id' => model(AccountsModel::class)->getAccount(session()->get('username'))['id'],
            'updated_at' => date('Y-m-d H:i:s', now(app_timezone())),
        ]);

        return redirect()->back();
    }

    /**
     * Renders the edit comment page.
     * @param mixed $comment_id
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function edit($comment_id) {
        if (session()->get('logged_in') !== true) {
            return redirect()->to('/login');
        }

        $comments_model = model(CommentsModel::class);
        $comment = $comments_model->find($comment_id);

        if ($comment === null) {
            return redirect()->to('/forum');
        }

        return view('components/header', ['title' => 'Edit Comment'])
            . view('components/nav')
            . view('forum/edit-comment', ['comment' => $comment])
            . view('components/footer');
    }

    /**
     * Processes the edit comment form.
     * @param mixed $comment_id
     * @return void
     */
    public function edit_comment($comment_id) {
        helper(['form', 'date']);
        $comments_model = model(CommentsModel::class);
        $comment = $comments_model->find($comment_id);
        $data = $this->request->getPost(['comment']);
        if (! $this->validateData($data, [
            'comment' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Please enter a comment.',
                    'max_length' => 'Your comment is too long. Please keep it under {param} characters.'
                ]
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $form_data = $this->validator->getValidated();

        $comments_model->update($comment_id, [
            'comment' => $form_data['comment'],
            'updated_at' => date('Y-m-d H:i:s', now(app_timezone())),
        ]);

        return redirect()->to("/forum/posts/{$comment['post_id']}");
    }

    public function delete_comment($comment_id) {
        $comments_model = model(CommentsModel::class);
        $comment = $comments_model->find($comment_id);

        if ($comment === null) {
            return redirect()->to('/forum');
        }

        $comments_model->delete($comment_id);

        return redirect()->to("/forum/posts/{$comment['post_id']}");
    }
}
