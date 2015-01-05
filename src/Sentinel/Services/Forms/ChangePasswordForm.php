<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class ChangePasswordForm extends FormValidator {

    protected $rules = [
        'oldPassword'              => 'min:8',
        'newPassword'              => 'required|min:8|confirmed',
        'newPassword_confirmation' => 'required'
    ];

    protected $messages = [];
}