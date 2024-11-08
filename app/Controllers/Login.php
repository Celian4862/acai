<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index() {
        return view('templates/header', ['title' => 'Login'])
            . view('components/nav')
            . view('login/login')
            . view('templates/footer');
    }

    public function fpass() {
        return view('templates/header', ['title' => 'Forgot Password'])
            . view('components/nav')
            . view('login/fpass')
            . view('templates/footer');
    }
}