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
            'username' => 'required|alpha_numeric_punct|max_length[30]',
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

        $data = $this->request->getPost('email');

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
        return redirect()->to('accounts/login')->with('success', 'Password reset link sent to email.');
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