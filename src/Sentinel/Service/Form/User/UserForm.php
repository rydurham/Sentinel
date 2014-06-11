<?php namespace Sentinel\Service\Form\User;

use Sentinel\Service\Validation\ValidableInterface;
use Sentinel\Repo\User\UserInterface;
use Illuminate\Config\Repository;

class UserForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Sentinel\Service\Form\ValidableInterface 
	 */
	protected $validator;

	/**
	 * Laravel Config Handler
	 */
	protected $config;

	/**
	 * Session Repository
	 *
	 * @var \Sentinel\Repo\Session\SessionInterface 
	 */
	protected $user;

	public function __construct(ValidableInterface $validator, UserInterface $user, Repository $config)
	{
		$this->validator = $validator;
		$this->user = $user;
		$this->config = $config;
	}

	/**
     * Create a new user
     *
     * @return integer
     */
    public function update(array $input)
    {
        if( ! $this->validForUpdate($input) )
        {
            return false;
        }

        return $this->user->update($input);
    }

	/**
	 * Return any validation errors
	 *
	 * @return array 
	 */
	public function errors()
	{
		return $this->validator->errors();
	}

	/**
	 * Test if form validator passes
	 *
	 * @return boolean 
	 */
	protected function valid(array $input)
	{
		// Check config for additional User form fields
		if ($this->config->has('Sentinel::config.additional_user_fields'))
		{
			$this->validator->addRules($this->config->get('Sentinel::config.additional_user_fields'));
		}

		return $this->validator->with($input)->passes();
		
	}

	/**
	 * Test if form validator passes
	 *
	 * @return boolean 
	 */
	protected function validForUpdate(array $input)
	{
		// Check config for additional User form fields
		if ($this->config->has('Sentinel::config.additional_user_fields'))
		{
			$this->validator->addRules($this->config->get('Sentinel::config.additional_user_fields'));
		}

		return $this->validator->with($input)->updateUnique('username', 'username', $input['id'])->passes();
		
	}


}