<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class ChangePasswordForm extends FormValidator {

    protected $rules = [
        'oldPassword'              => 'required|min:6',
        'newPassword'              => 'required|min:6|confirmed',
        'newPassword_confirmation' => 'required'
    ];

    protected $messages = [];
}