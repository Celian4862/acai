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
}
