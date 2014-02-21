<?php namespace Sentinel\Service\Form\ChangePassword;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class ChangePasswordFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'oldPassword' => 'required|min:6',
        'newPassword' => 'required|min:6|confirmed',
        'newPassword_confirmation' => 'required'
	);

}