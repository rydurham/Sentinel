<?php namespace Sentinel\Service\Validation;

interface ValidableInterface {

	/**
	 * Add data to validate against
	 * @param  array  $input 
	 * @return \Cesario\Service\Validation\ValidableInterface   $this
	 */
	public function with(array $input);

	/**
	 * Test if validation passes
	 * 
	 * @return boolean
	 */
	public function passes();

	/**
	 * Retreive validation errors
	 * 
	 * @return array
	 */
	public function errors();

}