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

    public function view(string $page = 'home') {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        return view('templates/header', ['title' => ucfirst($page) . ' - Açaí'])
            . view('pages/' . $page)
            . view('templates/footer');
    }
}
