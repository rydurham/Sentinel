<?php namespace Sentinel\Service\Form\SuspendUser;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class SuspendUserFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'minutes' => 'required|numeric',
	);

}