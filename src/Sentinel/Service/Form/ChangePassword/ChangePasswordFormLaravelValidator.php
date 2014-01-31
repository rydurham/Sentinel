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

	/**
	 * Custom Validation Messages
	 *
	 * @var Array 
	 */
	protected $messages = array(
		//'email.required' => 'An email address is required.'
		'oldPassword.required' => 'You must enter your old password.',
		'oldPassword.min' => 'Your old password must be at least 6 characters long.',
		'newPassword.required' => 'You must enter a new password.',
		'newPassword.min' => 'Your new password must be at least 6 characters long.',
		'newPassword_confirmation.required' => 'You must confirm your new password.'
	);
}