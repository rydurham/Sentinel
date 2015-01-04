<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class ResetPasswordForm extends FormValidator {

    protected $rules = [
        'password' => 'required|min:8|confirmed',
    ];

    protected $messages = [];
}