<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class LoginForm extends FormValidator {

    protected $rules = [
        'email'    => 'required|min:4|max:254',
        'password' => 'required|min:6'
    ];

    protected $messages = [];
}