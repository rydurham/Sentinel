<?php namespace Sentinel;

use BaseController, View, Input, Event, Redirect, Session, Paginator;
use Sentinel\Repositories\Group\SentinelGroupRepositoryInterface;
use Sentinel\Services\Forms\GroupCreateForm;
use Sentinel\Services\Forms\GroupUpdateForm;
use Sentinel\Traits\SentinelRedirectionTrait;

class GroupController extends BaseController {

    /**
     * Members
     */
    protected $group;
    protected $groupForm;
    /**
     * @var GroupCreateForm
     */
    private $groupCreateForm;
    /**
     * @var GroupUpdateForm
     */
    private $groupUpdateForm;

    /**
     * Traits
     */
    use SentinelRedirectionTrait;

    /**
     * Constructor
     */
	public function __construct(
        SentinelGroupRepositoryInterface $groupRepository,
        GroupCreateForm $groupCreateForm,
        GroupUpdateForm $groupUpdateForm
    )
	{
		$this->groupRepository = $groupRepository;
        $this->groupCreateForm = $groupCreateForm;
        $this->groupUpdateForm = $groupUpdateForm;

		// Establish Filters
		$this->beforeFilter('Sentinel\hasAccess:admin');
		$this->beforeFilter('Sentinel\csrf', ['on' => ['post', 'put', 'delete']]);
    }

	/**
	 * Display a paginated list of all current groups
	 *
	 * @return View
	 */
	public function index()
	{
        // Paginate the existing users
        $groups      = $this->groupRepository->all();
        $perPage     = 15;
        $currentPage = Input::get('page') - 1;
        $pagedData   = array_slice($groups, $currentPage * $perPage, $perPage);
        $groups      = Paginator::make($pagedData, count($groups), $perPage);

		return View::make('Sentinel::groups.index')->with('groups', $groups);
	}

	/**
	 * Show the form for creating a group
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('Sentinel::groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Redirect
	 */
	public function store()
	{
		// Gather input
        $data = Input::all();

        // Form Data Validation
        $this->groupCreateForm->validate($data);

		// Store the new group
        $result = $this->groupRepository->store($data);

        return $this->redirectViaResponse('groups.store', $result);
	}

	/**
	 * Display the specified group
	 *
	 * @return View
	 */
	public function show($id)
	{
		$group = $this->groupRepository->retrieveById($id);

		return View::make('Sentinel::groups.show')->with('group', $group);
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @return View
	 */
	public function edit($id)
	{
		$group = $this->groupRepository->retrieveById($id);

        return View::make('Sentinel::groups.edit')
            ->with('group', $group)
            ->with('permissions', $group->getPermissions());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Redirect
	 */
	public function update($id)
	{
		// Gather Input
        $data = Input::all();

        // Grab the group in question for the validator
        $group = $this->groupRepository->retrieveById($id);

        // Validate form data
        $this->groupUpdateForm->validate($data, $group);

		// Update the group
        $result = $this->groupRepository->update($data);

        return $this->redirectViaResponse('groups.update', $result);
	}

	/**
	 * Remove the specified group from storage.
	 *
	 * @return Redirect
	 */
	public function destroy($id)
	{
		$result = $this->groupRepository->destroy($id);

        return $this->redirectViaResponse('groups.destroy', $result);
	}

}