<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('templates/header', ['title' => 'A&ccedil;a&iacute;: Adaptive Community - Assisted Infrastructure'])
            . view('components/nav')
            . view('pages/index')
            . view('templates/footer');
    }

    public function login() {
        return view('templates/header', ['title' => 'Login - A&ccedil;a&iacute;'])
            . view('components/nav')
            . view('pages/login')
            . view('templates/footer');
    }
}
