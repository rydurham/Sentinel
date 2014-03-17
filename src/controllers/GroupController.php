<?php namespace Sentinel;

use Sentinel\Repo\Group\GroupInterface;
use Sentinel\Service\Form\Group\GroupForm;
use BaseController;
use View;
use Input;
use Event;
use Redirect;
use Session;

class GroupController extends BaseController {

	/**
	 * Member Vars
	 */
	protected $group;
	protected $groupForm;

	/**
	 * Constructor
	 */
	public function __construct(GroupInterface $group, GroupForm $groupForm) 
	{
		$this->group = $group;
		$this->groupForm = $groupForm;

		// Establish Filters
		$this->beforeFilter('Sentinel\inGroup:Admins');
		$this->beforeFilter('Sentinel\csrf', array('on' => array('post', 'put', 'delete')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = $this->group->all();
		return View::make('Sentinel::groups.index')->with('groups', $groups);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Form for creating a new Group
		return View::make('Sentinel::groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Form Processing
        $result = $this->groupForm->save( Input::all() );
        
        if( $result['success'] )
        {
            Event::fire('sentinel.group.created');

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\GroupController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\GroupController@create')
                ->withInput()
                ->withErrors( $this->groupForm->errors() );
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
		//Show a group and its permissions. 
		$group = $this->group->byId($id);

		return View::make('Sentinel::groups.show')->with('group', $group);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		$group = $this->group->byId($id);
		return View::make('Sentinel::groups.edit')->with('group', $group);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		// Form Processing
        $result = $this->groupForm->update( Input::all() );

        if( $result['success'] )
        {
            Event::fire('sentinel.group.updated', array(
                'groupId' => $id, 
            ));

            // Success!
            Session::flash('success', $result['message']);
            return Redirect::action('Sentinel\GroupController@index');

        } else {
            Session::flash('error', $result['message']);
            return Redirect::action('Sentinel\GroupController@edit', $id)
                ->withInput()
                ->withErrors( $this->groupForm->errors() );
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($this->group->destroy($id))
		{
			Event::fire('sentinel.group.destroyed', array(
                'groupId' => $id, 
            ));

			Session::flash('success', 'Group Deleted');
            return Redirect::action('Sentinel\GroupController@index');
        }
        else 
        {
        	Session::flash('error', 'Unable to Delete Group');
            return Redirect::action('Sentinel\GroupController@index');
        }
	}

}