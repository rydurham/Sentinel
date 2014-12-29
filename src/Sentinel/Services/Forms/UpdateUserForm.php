<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class CreateUserForm extends FormValidator {

    protected $rules = [
        'first_name' => 'alpha_spaces',
        'last_name'  => 'alpha_spaces',
        'username'   => 'unique:users,username'
    ];

    protected $messages = [];
}