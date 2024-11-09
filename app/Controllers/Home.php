<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(): string
    {
        return view('templates/header', ['title' => 'Adaptive Community-Assisted Infrastructure'])
            . view('components/nav')
            . view('pages/home')
            . view('templates/footer');
    }

    public function view(string $page) {
        $page = str_replace('-', '_', $page);
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }

        return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('pages/' . $page)
            . view('templates/footer');
    }
}
