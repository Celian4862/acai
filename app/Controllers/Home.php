<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index()
    {
        return view('components/header', ['title' => 'Adaptive Community-Assisted Infrastructure'])
            . view('components/nav')
            . view('pages/home')
            . view('components/footer');
    }

    public function view(string $page) {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }

        return view('components/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('pages/' . $page)
            . view('components/footer');
    }
}
