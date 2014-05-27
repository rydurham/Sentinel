<?php namespace Sentinel\Service\Form\ResetPassword;

use Sentinel\Service\Validation\ValidableInterface;

class ResetPasswordForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Cesario\Service\Form\ValidableInterface 
	 */
	protected $validator;

	/**
	 * Session Repository
	 *
	 * @var \Cesario\Repo\Session\SessionInterface 
	 */

	public function __construct(ValidableInterface $validator)
	{
		$this->validator = $validator;
	}

	/**
     *
     * @return integer
     */
    public function check(array $input)
    {
        if( ! $this->valid($input) )
        {
            return false;
        }
        return true;
    }

	/**
	 * Return any validation errors
	 *
	 * @return array 
	 */
	public function errors()
	{
		return $this->validator->errors();
	}

	/**
	 * Test if form validator passes
	 *
	 * @return boolean 
	 */
	protected function valid(array $input)
	{

		return $this->validator->with($input)->passes();
		
	}


}
