<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table = 'accounts';

    protected $allowedFields = ['username', 'email', 'password', 'birthdate', 'reset_token', 'token_expiry'];

    public function getAccount($name_email)
    {
        return $this->where('username', $name_email)
            ->orWhere('email', $name_email)
            ->first();
    }
}