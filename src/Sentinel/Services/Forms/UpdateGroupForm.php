<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class UpdateGroupForm extends FormValidator {

    protected $rules = [
        'name' => 'required|min:4|unique:groups',
    ];

    protected $messages = [];
}