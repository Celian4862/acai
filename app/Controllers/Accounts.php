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
            return redirect()->to('/forum/dashboard');
        }

        helper('form');

        return view('components/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('accounts/' . $page)
            . view('components/footer');
    }

    public function user_views($page = 'dashboard') {
        if (!is_file(APPPATH.'/Views/accounts/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return view('components/header', ['title' => ucwords(str_replace('-', ' ', $page))])
                . view('components/nav')
                . view('accounts/' . $page, session()->get())
                . view('components/footer');
        }

        return redirect('Accounts::view');
    }

    public function login() {
        helper('form');

        $data = $this->request->getPost(['name-email', 'password']);

        $seeder = \Config\Database::seeder();
        $seeder->call('AccountsTable');

        if (! $this->validateData($data, [
            'name-email' => [
                'label' => 'Username / Email',
                'rules' => 'required|min_length[6]|max_length[30]',
                'errors' => [
                    'required' => '{field} is required.',
                    'min_length' => '{field} must be at least {param} characters.',
                    'alpha_numeric_punct' => '{field} must contain only letters, numbers, and symbols.',
                    'max_length' => '{field} may contain up to {param} characters.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[255]|name_email_exists[name-email]|correct_password[name-email]',
                'errors' => [
                    'required' => '{field} is required.',
                    'min_length' => '{field} must be at least {param} characters.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'name_email_exists' => 'User does not exist.',
                    'correct_password' => 'Incorrect password.',
                ],
            ],
        ])) {
            return redirect()->to('/accounts/login')->withInput();
        }

        $post = $this->validator->getValidated();

        $model = model(AccountsModel::class);

        $account = $model->getAccount($post['name-email']);

        $account_data = [
            'email' => $account['email'],
            'username' => $account['username'],
            'birthdate' => $account['birthdate'],
            'logged_in' => true
        ];

        session()->set($account_data);

        return redirect()->to('/forum/dashboard');
    }

    public function create_account()
    {
        helper('form');

        $seeder = \Config\Database::seeder();
        $seeder->call('AccountsTable');

        $data = $this->request->getPost(['email', 'username', 'password', 'confirm-pass', 'birthdate']);

        if (! $this->validateData($data, [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[accounts.email]',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_email' => '{field} is not valid.',
                    'is_unique' => '{field} is already in use.',
                ],
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|alpha_numeric|min_length[6]|max_length[30]|is_unique[accounts.username]',
                'errors' => [
                    'required' => '{field} is required.',
                    'alpha_numeric' => '{field} must contain only letters and numbers.',
                    'min_length[6]' => '{field} must be at least six letters.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'is_unique' => '{field} is already in use.',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[255]|password_ok',
                'errors' => [
                    'required' => '{field} is required.',
                    'min_length' => '{field} must be at least {param} characters.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'password_ok' => '{field} must be at least 16 characters or be at least 8 characters and contain at least one letter, number, and symbol.',
                ],
            ],
            'confirm-pass' => [
                'label' => 'Password confirmation',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'matches' => '{field} does not match.',
                ],
            ],
            'birthdate' => [
                'label' => 'Date of birth',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_date' => '{field} must be valid.',
                ],
            ],
        ])) {
            return redirect()->back()->withInput();
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

        return redirect()->to('/forum/dashboard');
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
            return redirect()->back()->withInput();
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

        if (! $this->validateData($data, [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|unique_email',
                'errors' => [
                    'valid_email' => '{field} is not valid.',
                    'unique_email' => '{field} is already in use.',
                ],
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|alpha_numeric|min_length[6]|max_length[30]|unique_username',
                'errors' => [
                    'required' => '{field} is required.',
                    'alpha_numeric' => '{field} must contain only letters and numbers.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'unique_username' => '{field} has been taken.',
                ],
            ],
            'old-pass' => [
                'label' => 'Old password',
                'rules' => 'permit_empty|required_with[new-pass]|min_length[8]|max_length[255]|correct_password[username]',
                'errors' => [
                    'min_length' => '{field} must be at least {param} characters.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'correct_password' => 'Incorrect password.',
                ],
            ],
            'new-pass' => [
                'label' => 'New password',
                'rules' => 'required_with[old-pass]|permit_empty|min_length[8]|max_length[255]|differs[old-pass]|password_ok',
                'errors' => [
                    'required_with' => '{field} is required with {param}.',
                    'min_length' => '{field} must be at least {param} characters.',
                    'max_length' => '{field} may contain up to {param} characters.',
                    'old_pass_correct' => 'Old password is incorrect or missing.',
                    'no_match_old_pass' => '{field} must be different from old password.',
                    'password_ok' => '{field} must be at least 16 characters or be at least 8 characters and contain at least one letter, number, and symbol.',
                ],
            ],
            'confirm-pass' => [
                'label' => 'Password confirmation',
                'rules' => 'matches[new-pass]',
                'errors' => [
                    'matches' => 'Passwords do not match.',
                ],
            ],
            'birthdate' => [
                'label' => 'Date of birth',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} is required.',
                    'valid_date' => '{field} must be valid.',
                ],
            ]
        ])) {
            return redirect()->back()->withInput();
        }

        $post = $this->validator->getValidated();

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