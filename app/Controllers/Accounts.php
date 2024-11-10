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

        if (! $this->validateData($data, [
            'name-email' => 'required|alpha_numeric_punct|max_length[30]',
            'password' => 'required|min_length[8]|max_length[255]'
        ])) {
            return $this->view('login');
        }

        $post = $this->validator->getValidated();

        $model = model(AccountsModel::class);

        $account = $model->getAccount($post['name-email']);

        if (! $account || ! password_verify($post['password'], $account['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        $account_data = [
            'email' => $account['email'],
            'username' => $account['username'],
            'birthdate' => $account['birthdate'],
            'logged_in' => true
        ];

        session()->set($account_data);

        return view('templates/header', ['title' => 'Logged in'])
            . view('components/nav')
            . view('accounts/success', ['message' => 'You have been logged in.'])
            . view('templates/footer');
    }

    public function create_account()
    {
        helper('from');

        $data = $this->request->getPost(['email', 'username', 'password', 'confirm-password', 'birthdate']);

        if (! $this->validateData($data, [
            'email' => 'required|valid_email|is_unique[accounts.email]',
            'username' => 'required|alpha_numeric|max_length[30]',
            'password' => 'required|min_length[8]|max_length[255]',
            'confirm-password' => 'required|matches[password]',
            'birthdate' => 'required|valid_date'
        ])) {
            return $this->view('signup');
        }

        $post = $this->validator->getValidated();

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

        return view('templates/header', ['title' => 'Success'])
            . view('components/nav')
            . view('accounts/success', ['message' => 'Account created.'])
            . view('templates/footer');
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

        $data = $this->request->getPost(['email', 'username', 'old-password', 'new-password', 'confirm-password', 'birthdate']);

        if (! $this->validateData($data, [
            'email' => 'required|valid_email',
            'username' => 'required|alpha_numeric|max_length[30]',
            'old-password' => 'max_length[255]',
            'new-password' => 'max_length[255]',
            'confirm-password' => 'matches[new-password]',
            'birthdate' => 'required|valid_date'
        ])) {
            return $this->user_views('settings');
        }

        $post = $this->validator->getValidated();

        $errors = [];

        $account = model(AccountsModel::class)->getAccount(session()->get('email'));

        if (! $post['old-password'] && ($post['new-password'] || $post['confirm-password'])) {
            $errors['old-password'] = 'Old password required.';
        } else if ($post['old-password'] && ! ($post['new-password'] || $post['confirm-password'])) {
            $errors['new-password'] = 'New password required.';
            $errors['confirm-password'] = 'Confirm password required.';
        }
        
        if ($post['email'] !== session()->get('email')) {
            if (model(AccountsModel::class)->getAccount($post['email'])) {
                $errors['email'] = 'Email already in use.';
            }
        }

        if ($post['username'] !== session()->get('username')) {
            if (model(AccountsModel::class)->getAccount($post['username'])) {
                $errors['username'] = 'Username already in use.';
            }
        }
        
        if (! password_verify($post['old-password'], $account['password'])) {
            $errors['old-password'] = 'Incorrect password.';
        }

        if ($post['new-password'] === $post['old-password']) {
            $errors['new-password'] = 'New password must be different from old password.';
        } else if ($post['new-password'] && strlen($post['new-password']) < 8) {
            $errors['new-password'] = 'New password must be at least 8 characters long.';
        } if ($post['new-password'] !== $post['confirm-password']) {
            $errors['confirm-password'] = 'Passwords do not match.';
        }

        if (count($errors) > 0) {
            session()->setFlashdata('custom_errors', $errors);
            return $this->user_views('settings');
        }

        return view('templates/header', ['title' => 'Settings updated'])
            . view('components/nav')
            . view('accounts/success', ['message' => 'Settings updated.'])
            . view('templates/footer');
    }

    public function logout() {
        if (session()->get('logged_in') && session()->get('logged_in') === true) {
            session()->set('logged_in', false);
            session()->destroy();
            return view('templates/header', ['title' => 'Logged out'])
                . view('components/nav')
                . view('accounts/success', ['message' => 'You have been logged out.'])
                . view('templates/footer');
        }
        return redirect()->to('/');
    }
}