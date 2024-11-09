<?php

namespace App\Controllers;

use App\Models\AccountsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Accounts extends BaseController
{
    public function view($page = 'login') {
        helper('form');
        if (!is_file(APPPATH.'/Views/accounts/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        return view('templates/header', ['title' => ucfirst($page)])
            . view('components/nav')
            . view('accounts/' . $page)
            . view('templates/footer');
    }

    public function dashboard() {
        if (! session()->has('logged_in') || session()->get('logged_in') !== true) {
            return redirect()->to('/accounts/login');
        }
        
        return view('templates/header', ['title' => 'Dashboard'])
            . view('components/nav')
            . view('accounts/dashboard', session()->get())
            . view('templates/footer');
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

        return redirect()->to('accounts/dashboard');
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

        return redirect()->to('accounts/dashboard');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }
}