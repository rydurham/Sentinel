<?php namespace Sentinel\Services\Forms;

use Sentinel\Services\Validation\FormValidator;

class GroupCreateForm extends FormValidator {

    protected $rules = [
        'name' => 'required|min:4|unique:groups',
    ];

    protected $messages = [];
}