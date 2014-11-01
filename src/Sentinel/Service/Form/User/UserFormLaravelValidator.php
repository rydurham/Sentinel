<?php namespace Sentinel\Service\Form\User;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'first_name' => 'alpha_spaces',
		'last_name' => 'alpha_spaces',
		'username' => 'unique:users,username'
	);

}
