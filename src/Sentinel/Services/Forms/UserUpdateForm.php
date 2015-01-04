<?php namespace Sentinel\Services\Forms;

use Illuminate\Config\Repository;
use Illuminate\Validation\Factory;
use Sentinel\Services\Validation\FormValidator;

class UserUpdateForm extends FormValidator {

    public function __construct(Factory $validator, Repository $config)
    {
        $this->validator = $validator;
        $this->config = $config;
    }

    protected $rules = [];

    protected $messages = [];

    /**
     * Add custom user fields to the expected validation rules
     * @return mixed
     */
    public function getRules()
    {
        return $this->config->get('Sentinel::auth.additional_user_fields');
    }
}