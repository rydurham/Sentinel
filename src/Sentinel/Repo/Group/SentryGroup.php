<?php namespace Sentinel\Repo\Group;

use Cartalyst\Sentry\Sentry;
use Sentinel\Repo\RepoAbstract;

class SentryGroup extends RepoAbstract implements GroupInterface {
	
	protected $sentry;

	/**
	 * Construct a new SentryGroup Object
	 */
	public function __construct(Sentry $sentry)
	{
		$this->sentry = $sentry;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data)
	{
		// Back suppport for previous permissions options
		if (array_key_exists('adminPermissions', $data)) $data['permissions']['admin'] = 1;
		if (array_key_exists('userPermissions', $data)) $data['permissions']['users'] = 1;

		// Does the permissions array exist in the $data array?
		if ( ! array_key_exists('permissions', $data))
		{
			$data['permissions'] = array();
		}

		$result = array();
		try {
			    // Create the group
			    $group = $this->sentry->createGroup(array(
			        'name'        => e($data['name']),
			        'permissions' => $data['permissions'],
			    ));

			   	$result['success'] = true;
	    		$result['message'] = trans('Sentinel::groups.created'); 
		}
		catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = trans('Sentinel::groups.loginreq');
		}
		catch (\Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $result['success'] = false;
	    	$result['message'] = trans('Sentinel::groups.userexists');;
		}

		return $result;
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($data)
	{
		// Back suppport for previous permissions options
		if (array_key_exists('adminPermissions', $data)) $data['permissions']['admin'] = 1;
		if (array_key_exists('userPermissions', $data)) $data['permissions']['users'] = 1;

		// Does the permissions array exist in the $data array?
		if ( ! array_key_exists('permissions', $data))
		{
			$data['permissions'] = array();
		}

		try
		{
			// Find the group using the group id
		    $group = $this->sentry->findGroupById($data['id']);

		    // Grab the current (pre-edit) permissions and nullify appropriately
		    $existingPermissions = $group->getPermissions();
		    $nulledPermissions = array_diff_key($existingPermissions, $data['permissions']);
			foreach ($nulledPermissions as $key => $value) {
				// Set the nulled permissions to 0
				$data['permissions'][$key] = 0;
			}

		    // Update the group details
		    $group->name = e($data['name']);
		    $group->permissions = $data['permissions'];

		    // Update the group
		    if ($group->save())
		    {
		        // Group information was updated
		        $result['success'] = true;
				$result['message'] = trans('Sentinel::groups.updated');;
		    }
		    else
		    {
		        // Group information was not updated
		        $result['success'] = false;
				$result['message'] = trans('Sentinel::groups.updateproblem');;
		    }
		}
		catch (\Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
			$result['success'] = false;
			$result['message'] = trans('Sentinel::groups.namereq');;
		}
		catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			$result['success'] = false;
			$result['message'] = trans('Sentinel::groups.groupexists');;
		}
		catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			$result['success'] = false;
			$result['message'] = trans('Sentinel::groups.notfound');
		}

		return $result;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
		    // Find the group using the group id
		    $group = $this->sentry->findGroupById($id);

		    // Delete the group
		    $group->delete();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return true;
	}

	/**
	 * Return a specific group by a given id
	 * 
	 * @param  integer $id
	 * @return Group
	 */
	public function byId($id)
	{
		try
		{
		    $group = $this->sentry->findGroupById($id);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return $group;
	}

	/**
	 * Return a specific group by a given name
	 * 
	 * @param  string $name
	 * @return Group
	 */
	public function byName($name)
	{
		try
		{
		    $group = $this->sentry->findGroupByName($name);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return false;
		}
		return $group;
	}

	/**
	 * Return all the registered groups
	 *
	 * @return stdObject Collection of groups
	 */
	public function all()
	{
		return $this->sentry->getGroupProvider()->findAll();
	}
}
