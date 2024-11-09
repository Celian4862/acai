<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index()
    {
        return view('templates/header', ['title' => 'Adaptive Community-Assisted Infrastructure'])
            . view('components/nav')
            . view('pages/home')
            . view('templates/footer');
    }

    public function view(string $page) {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return redirect()->to('accounts/dashboard');
        }

        return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('pages/' . $page)
            . view('templates/footer');
    }
}
