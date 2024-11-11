<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $login = [
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
    ];
    
    /**
     * Ruleset for signup form
     * @var array
     */
    public array $signup = [
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[accounts.email]',
            'errors' => [
                'required' => '{field} is required.',
                'valid_email' => 'Email is not valid.',
                'is_unique' => 'Email is already in use.',
            ],
        ],
        'username' => [
            'label' => 'Username',
            'rules' => 'required|alpha_numeric|min_length[6]|max_length[30]',
            'errors' => [
                'required' => '{field} is required.',
                'alpha_numeric' => '{field} must contain only letters and numbers.',
                'max_length' => '{field} may contain up to {param} characters.',
            ],
        ],
        'password' => [
            'label' => 'Password',
            'rules' => 'required|min_length[8]|max_length[255]',
            'errors' => [
                'required' => '{field} is required.',
                'min_length' => '{field} must be at least {param} characters.',
                'max_length' => '{field} may contain up to {param} characters.',
            ],
        ],
        'confirm-pass' => [
            'label' => 'Password confirmation',
            'rules' => 'required|matches[password]',
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
        ],
    ];

    /**
     * Ruleset for user settings form
     * @var array
     */
    public array $user_settings = [
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email|unique_email',
            'errors' => [
                'valid_email' => 'Email is not valid.',
                'unique_email' => 'Email is already in use.',
            ],
        ],
        'username' => [
            'label' => 'Username',
            'rules' => 'required|alpha_numeric|max_length[30]|unique_username',
            'errors' => [
                'required' => '{field} is required.',
                'alpha_numeric' => '{field} must contain only letters and numbers.',
                'max_length' => '{field} may contain up to {param} characters.',
                'unique_username' => '{field} has been taken.',
            ],
        ],
        'old-pass' => [
            'label' => 'Old password',
            'rules' => 'permit_empty|min_length[8]|max_length[255]|correct_password[username]',
            'errors' => [
                'min_length' => '{field} must be at least {param} characters.',
                'max_length' => '{field} may contain up to {param} characters.',
                'correct_password' => 'Incorrect password.',
            ],
        ],
        'new-pass' => [
            'label' => 'New password',
            'rules' => 'permit_empty|min_length[8]|max_length[255]|no_match_old_pass|password_ok',
            'errors' => [
                'min_length' => '{field} must be at least {param} characters.',
                'max_length' => '{field} may contain up to {param} characters.',
                'no_match_old_pass' => 'New password must be different from the old password.',
                'password_ok' => '{field} must contain at least one letter, number, and symbol.',
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
    ];
}
