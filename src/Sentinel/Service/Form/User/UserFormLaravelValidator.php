<?php namespace Sentinel\Service\Form\User;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'firstName' => 'alpha_dash',
		'lastName' => 'alpha_dash',
		'username' => 'unique:users,username'
	);

}