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

    public array $user_settings = [
        'email' => [
            'label' => 'Email',
            'rules' => 'required|valid_email',
            'errors' => [
                'valid_email' => 'Email is not valid.',
            ]
        ],
        'username' => [
            'label' => 'Username',
            'rules' => 'required|alpha_numeric|max_length[30]',
            'errors' => [
                'required' => '{field} is required.',
                'alpha_numeric' => '{field} must contain only letters and numbers.',
                'max_length' => '{field} may contain up to {param} characters.',
            ],
        ],
        'old-pass' => [
            'label' => 'Old password',
            'rules' => 'field_exists|permit_empty|min_length[8]|max_length[255]',
            'errors' => [
                'min_length' => '{field} must be at least {param} characters.',
                'max_length' => '{field} may contain up to {param} characters.',
            ],
        ],
        'new-pass' => [
            'label' => 'New password',
            'rules' => 'permit_empty|min_length[8]|max_length[255]',
            'errors' => [
                'min_length' => '{field} must be at least {param} characters.',
                'max_length' => '{field} may contain up to {param} characters.',
            ],
        ],
        'confirm-pass' => [
            'label' => 'Password confirmation',
            'rules' => 'matches[new-pass]',
            'errors' => [
                ''
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
