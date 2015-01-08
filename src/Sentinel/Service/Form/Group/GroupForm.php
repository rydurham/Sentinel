<?php namespace Sentinel\Service\Form\Group;

use Sentinel\Service\Validation\ValidableInterface;
use Sentinel\Repo\Group\GroupInterface;

class GroupForm {

	/**
	 * Form Data
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Validator
	 *
	 * @var \Sentinel\Service\Form\ValidableInterface 
	 */
	protected $validator;

	/**
	 * Group Repository
	 *
	 * @var \Sentinel\Repo\Group\GroupInterface 
	 */
	protected $group;

	public function __construct(ValidableInterface $validator, GroupInterface $group)
	{
		$this->validator = $validator;
		$this->group = $group;
	}

	/**
     * Create a new group
     *
     * @return integer
     */
    public function save(array $input)
    {
        if( ! $this->validForSave($input) )
        {
            return false;
        }

        return $this->group->store($input);
    }

    /**
     * Update new group
     *
     * @return integer
     */
    public function update(array $input)
    {
        if( ! $this->validForUpdate($input) )
        {
            return false;
        }

        return $this->group->update($input);
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
	protected function validForUpdate(array $input)
	{
		return $this->validator->with($input)->updateUnique('name', 'id', $input['id'])->passes();
	}

    /**
     * Test if form validator passes
     *
     * @return boolean
     */
    protected function validForSave(array $input)
    {
        return $this->validator->with($input)->passes();
    }


}
