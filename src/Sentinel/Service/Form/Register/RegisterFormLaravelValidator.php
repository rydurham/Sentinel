<?php namespace Sentinel\Service\Form\Register;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class RegisterFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'email' => 'required|min:4|max:32|email',
		'password' => 'required|min:6|confirmed',
		'password_confirmation' => 'required'
	);

}