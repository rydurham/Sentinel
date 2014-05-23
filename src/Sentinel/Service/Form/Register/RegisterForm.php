<?php namespace Sentinel\Service\Form\Register;

use Sentinel\Service\Validation\ValidableInterface;
use Sentinel\Repo\User\UserInterface;
use Illuminate\Config\Repository;

class RegisterForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Cesario\Service\Form\ValidableInterface 
	 */
	protected $validator;

	/**
	 * Laravel Config Handler
	 */
	protected $config;

	/**
	 * User Repository
	 *
	 * @var \Cesario\Repo\User\UserInterface 
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
    public function save(array $input)
    {
        if( ! $this->valid($input) )
        {
            return false;
        }

        return $this->user->store($input);
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


}