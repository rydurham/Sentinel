<?php namespace Sentinel\Service\Form\ChangePassword;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class ChangePasswordFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'oldPassword' => 'required|between:8,30',
        'newPassword' => 'required|between:8,30|confirmed',
        'newPassword_confirmation' => 'required'
	);

}
