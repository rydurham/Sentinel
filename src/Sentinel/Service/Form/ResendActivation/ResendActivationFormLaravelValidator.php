<?php namespace Sentinel\Service\Form\ResendActivation;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class ResendActivationFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'email' => 'required|min:4|max:32|email',
	);

	/**
	 * Custom Validation Messages
	 *
	 * @var Array 
	 */
	protected $messages = array(
		//'email.required' => 'An email address is required.'
	);
}