<?php namespace Sentinel\Service\Form\ResetPassword;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class ResetPasswordFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
        'newPassword' => 'required|between:8,30|confirmed',
        'newPassword_confirmation' => 'required'
	);

}
