<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accounts extends BaseController
{
    public function view($page = 'login') {
        if (!is_file(APPPATH.'/Views/accounts/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return redirect()->to('/accounts/dashboard');
        }

        helper('form');

        return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('accounts/' . $page)
            . view('templates/footer');
    }

    public function user_views($page = 'dashboard') {
        if (!is_file(APPPATH.'/Views/accounts/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
                . view('components/nav')
                . view('accounts/' . $page, session()->get())
                . view('templates/footer');
        }

        return redirect('Accounts::view');
    }

    public function login() {
        helper('form');

        $data = $this->request->getPost(['name-email', 'password']);

        $seeder = \Config\Database::seeder();
        $seeder->call('AccountsTable');

        $validator = service('validation');

        if (! $validator->run($data, 'login')) {
            return redirect()->to('/accounts/login')->withInput();
        }

        $post = $validator->getValidated();

        $model = model(AccountsModel::class);

        $account = $model->getAccount($post['name-email']);

        $account_data = [
            'email' => $account['email'],
            'username' => $account['username'],
            'birthdate' => $account['birthdate'],
            'logged_in' => true
        ];

        session()->set($account_data);

        return redirect()->to('/accounts/dashboard');
    }

    public function create_account()
    {
        helper('form');

        $seeder = \Config\Database::seeder();
        $seeder->call('AccountsTable');

        $data = $this->request->getPost(['email', 'username', 'password', 'confirm-pass', 'birthdate']);

        $validator = service('validation');

        if (! $validator->run($data, 'signup')) {
            return redirect()->back()->withInput();
        }

        $post = $validator->getValidated();

        $model = model(AccountsModel::class);

        $model->save([
            'email' => $post['email'],
            'username' => $post['username'],
            'password' => password_hash($post['password'],PASSWORD_DEFAULT),
            'birthdate' => $post['birthdate']
        ]);

        $account_data = [
            'email' => $post['email'],
            'username' => $post['username'],
            'birthdate' => $post['birthdate'],
            'logged_in' => true
        ];

        session()->set($account_data);

        return redirect()->to('/accounts/dashboard');
    }

    public function forgot_password() {
        helper('form');

        $data = $this->request->getPost(['email']);

        $seeder = \Config\Database::seeder();
        $seeder->call('AccountsTable');

        if (! $this->validateData($data, [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|name_email_exists[email]',
                'errors' => [
                    'required' => '{field} field is required.',
                    'valid_email' => '{field} is not valid.',
                    'name_email_exists' => '{field} not found.',
                ],
            ],
        ])) {
            return redirect()->to('/accounts/forgot-password')->withInput();
        }

        $post = $this->validator->getValidated();

        $model = model(AccountsModel::class);

        // Send email with password reset link

        // Go back to forgot-password page with success message
        session()->setFlashdata('success', 'Password reset link sent to email');
        return redirect()->back();
    }

    public function settings() {
        helper('form');

        $data = $this->request->getPost(['email', 'username', 'old-pass', 'new-pass', 'confirm-pass', 'birthdate']);

        $validation = service('validation');

        if (! $validation->run($data, 'user_settings')) {
            return redirect()->back()->withInput();
        }

        $post = $validation->getValidated();

        $model = model(AccountsModel::class);

        $new_data = [
            'id' => $model->getAccount(session()->get('username'))['id'],
            'email' => $post['email'],
            'username' => $post['username'],
            'birthdate' => $post['birthdate'],
        ];

        if ($post['new-pass'] != null) {
            $new_data['password'] = password_hash($post['new-pass'], PASSWORD_DEFAULT);
        }

        // Update account details
        $model->save($new_data);

        // Prepare new session data
        $account_data = [
            'email' => $post['email'],
            'username' => $post['username'],
            'birthdate' => $post['birthdate'],
        ];

        // Update session data
        session()->set($account_data);

        // Redirect to settings page with success message
        session()->setFlashdata('success', 'Account updated successfully');
        return redirect()->to('/accounts/settings');
    }

    /**
     * Destroys the current user's session to log out.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout() {
        if (session()->get('logged_in') && session()->get('logged_in') === true) {
            session()->set('logged_in', false);
            session()->destroy();
        }
        return redirect()->to('/');
    }

    /**
     * Deletes account
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete_account() {
        helper('form');

        $model = model(AccountsModel::class);
        $user_id = $model->getAccount(session()->get('username'))['id'];

        if ($model->delete($user_id)) {
            session()->destroy();
            return redirect()->to('/');
        } else {
            session()->setFlashdata('error', 'Failed to delete account');
            return redirect()->back();
        }
    }
}