<?php namespace Sentinel\Services\Forms;

use Illuminate\Config\Repository;
use Illuminate\Validation\Factory;
use Sentinel\Services\Validation\FormValidator;

class UserCreateForm extends FormValidator {

    public function __construct(Factory $validator, Repository $config)
    {
        $this->validator = $validator;
        $this->config = $config;
    }

    protected $rules = [
        'email' => 'required|min:4|max:254|email',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required',
    ];

    protected $messages = [];


    /**
     * Get UserCreateForm Validation Rules
     * @return mixed
     */
    public function getRules()
    {
        // If Usernames are enabled, add username validation rules
        if ($this->config->get('Sentinel::auth.allow_usernames')) {
            $this->rules['username'] = 'required|unique:users,username';
        }

        return $this->rules;
    }
}