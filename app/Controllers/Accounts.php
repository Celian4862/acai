<?php

namespace App\Controllers;

class Accounts extends BaseController
{
    public function index() {
        helper('form');
        return view('templates/header', ['title' => 'Login'])
            . view('components/nav')
            . view('accounts/login')
            . view('templates/footer');
    }

    public function fpass() {
        helper('form');
        return view('templates/header', ['title' => 'Forgot Password'])
            . view('components/nav')
            . view('accounts/forgot-password')
            . view('templates/footer');
    }

    public function signup() {
        helper('form');
        return view('templates/header', ['title' => 'Sign Up'])
            . view('components/nav')
            . view('accounts/signup')
            . view('templates/footer');
    }
}