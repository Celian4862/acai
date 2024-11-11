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
            return redirect()->to('accounts/dashboard');
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

        $validator = service('validation');

        if (! $validator->run($data, 'login')) {
            return redirect()->to('accounts/login')->withInput();
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

        return redirect()->to('accounts/dashboard');
    }

    public function create_account()
    {
        helper('form');

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

        return redirect()->to('accounts/dashboard');
    }

    public function forgot_password() {
        helper('form');

        $data = $this->request->getPost(['email']);

        if (! $this->validateData($data, [
            'email' => 'required|valid_email'
        ])) {
            return $this->view('forgot-password');
        }

        $post = $this->validator->getValidated();

        $model = model(AccountsModel::class);

        $account = $model->getAccount($post['email']);

        if (! $account) {
            return redirect()->back()->withInput()->with('error', 'Email not found.');
        }

        // Send email with password reset link
        return view('templates/header', ['title' => 'Logged out'])
        . view('components/nav')
        . view('accounts/success', ['message' => 'Password reset link sent to email.'])
        . view('templates/footer');
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

        // Update account details
        $model->save([
            'id' => $model->getAccount(session()->get('username'))['id'],
            'email' => $post['email'],
            'username' => $post['username'],
            'password' => password_hash($post['new-pass'], PASSWORD_DEFAULT),
            'birthdate' => $post['birthdate']
        ]);

        // Prepare new session data
        $account_data = [
            'email' => $post['email'],
            'username' => $post['username'],
            'birthdate' => $post['birthdate']
        ];

        // Update session data
        session()->set($account_data);

        return redirect()->to('accounts/settings');
    }

    public function logout() {
        if (session()->get('logged_in') && session()->get('logged_in') === true) {
            session()->set('logged_in', false);
            session()->destroy();
        }
        return redirect()->to('/');
    }
}