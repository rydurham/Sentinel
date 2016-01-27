<?php

namespace Sentinel\Controllers;

use View;
use Sentry;
use Request;
use Redirect;
use Vinkla\Hashids\HashidsManager;
use Illuminate\Pagination\Paginator;
use Sentinel\Traits\SentinelViewfinderTrait;
use Sentinel\FormRequests\GroupCreateRequest;
use Sentinel\Traits\SentinelRedirectionTrait;
use Illuminate\Routing\Controller as BaseController;
use Sentinel\Repositories\Group\SentinelGroupRepositoryInterface;

class GroupController extends BaseController
{
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
        HashidsManager $hashids
    ) {
        $this->groupRepository = $groupRepository;
        $this->hashids         = $hashids;

        // You must have admin access to proceed
        $this->middleware('sentry.admin');
    }

    /**
     * Display a paginated list of all current groups
     *
     * @return View
     */
    public function index()
    {
        // Get a paginated set of groups
        $groups = Sentry::getGroupProvider()->createModel()->paginate(15);

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
    public function store(GroupCreateRequest $request)
    {
        // Gather input
        $data = Request::all();

        // Store the new group
        $result = $this->groupRepository->store($data);

        return $this->redirectViaResponse('groups_store', $result);
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
            'permissions' => $group->getPermissions()
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
        $data = Request::all();

        // Decode the hashid
        $data['id'] = $this->hashids->decode($hash)[0];

        // Update the group
        $result = $this->groupRepository->update($data);

        return $this->redirectViaResponse('groups_update', $result);
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

        return $this->redirectViaResponse('groups_destroy', $result);
    }
}
