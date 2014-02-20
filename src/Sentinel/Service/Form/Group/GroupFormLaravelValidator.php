<?php namespace Sentinel\Service\Form\Group;

use Sentinel\Service\Validation\AbstractLaravelValidator;

class GroupFormLaravelValidator extends AbstractLaravelValidator {
	
	/**
	 * Validation rules
	 *
	 * @var Array 
	 */
	protected $rules = array(
		'name' => 'required|min:4'
	);

}