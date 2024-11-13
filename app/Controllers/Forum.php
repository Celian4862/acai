<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Forum extends BaseController
{
    public function view($page = 'dashboard') {
        if (!is_file(APPPATH.'/Views/forum/'.$page.'.php')) {
            throw new PageNotFoundException($page);
        }

        if (session()->has('logged_in') && session()->get('logged_in') === true) {
            return view('templates/header', ['title' => ucwords(str_replace('-', ' ', $page))])
            . view('components/nav')
            . view('forum/' . $page, session()->get())
            . view('templates/footer');
        }

        return redirect('Accounts::view');
    }
}