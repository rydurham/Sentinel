<?php namespace Sentinel;

use BaseController, View, Input, Redirect, Paginator;
use Hashids\Hashids;
use Sentinel\Repositories\Group\SentinelGroupRepositoryInterface;
use Sentinel\Services\Forms\GroupCreateForm;
use Sentinel\Services\Forms\GroupUpdateForm;
use Sentinel\Traits\SentinelRedirectionTrait;
use Sentinel\Traits\SentinelViewfinderTrait;

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
    use SentinelViewfinderTrait;

    /**
     * Constructor
     */
	public function __construct(
        SentinelGroupRepositoryInterface $groupRepository,
        GroupCreateForm $groupCreateForm,
        GroupUpdateForm $groupUpdateForm,
        Hashids $hashids
    )
	{
		$this->groupRepository = $groupRepository;
        $this->groupCreateForm = $groupCreateForm;
        $this->groupUpdateForm = $groupUpdateForm;
        $this->hashids         = $hashids;

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

		return $this->viewFinder('Sentinel::groups.index', ['groups' => $groups]);
	}

	/**
	 * Show the form for creating a group
	 *
	 * @return View
	 */
	public function create()
	{
		return $this->viewFinder('Sentinel::groups.create');
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
	public function show($hash)
	{
        // Decode the hashid
        $id = $this->hashids->decode($hash)[0];

        // Pull the group from storage
        $group = $this->groupRepository->retrieveById($id);

        return $this->viewFinder('Sentinel::groups.show', ['group' => $group]);
	}

	/**
	 * Show the form for editing the specified group.
	 *
	 * @return View
	 */
	public function edit($hash)
	{
        // Decode the hashid
        $id = $this->hashids->decode($hash)[0];

        // Pull the group from storage
        $group = $this->groupRepository->retrieveById($id);

        return $this->viewFinder('Sentinel::groups.edit', [
            'group' => $group,
            'permissions', $group->getPermissions()
        ]);
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Redirect
	 */
	public function update($hash)
	{
		// Gather Input
        $data = Input::all();

        // Decode the hashid
        $data['id'] = $this->hashids->decode($hash)[0];

        // Grab the group in question for the validator
        $group = $this->groupRepository->retrieveById($data['id']);

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
	public function destroy($hash)
	{
        // Decode the hashid
        $id = $this->hashids->decode($hash)[0];

        // Remove the group from storage
        $result = $this->groupRepository->destroy($id);

        return $this->redirectViaResponse('groups.destroy', $result);
	}

}