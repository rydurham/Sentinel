<?php namespace Sentinel\Service\Form\User;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class UserFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'firstName' => 'alpha',
        'lastName' => 'alpha',
	);

}