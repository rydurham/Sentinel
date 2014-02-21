<?php namespace Sentinel\Service\Form\ForgotPassword;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class ForgotPasswordFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'email' => 'required|min:4|max:32|email',
	);

}