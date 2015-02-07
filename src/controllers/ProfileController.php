<?php namespace App\Http\Controllers\Sentinel;

use Hashids\Hashids;
use Sentinel\Services\Forms\ChangePasswordForm;
use Sentinel\Services\Forms\UserUpdateForm;
use Session, Input, Response, Redirect;
use Sentinel\Repositories\Group\SentinelGroupRepositoryInterface;
use Sentinel\Repositories\User\SentinelUserProviderInterface;
use Sentinel\Traits\SentinelRedirectionTrait;
use Sentinel\Traits\SentinelViewfinderTrait;

class ProfileController extends \BaseController {

    /**
     * Traits
     */
    use SentinelRedirectionTrait;
    use SentinelViewfinderTrait;

    public function __construct(
        SentinelUserProviderInterface $userRepository,
        SentinelGroupRepositoryInterface $groupRepository,
        UserUpdateForm $userUpdateForm,
        ChangePasswordForm $changePasswordForm,
        Hashids $hashids
    )
    {
        // DI Member assignment
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->userUpdateForm = $userUpdateForm;
        $this->changePasswordForm = $changePasswordForm;
        $this->hashids = $hashids;

        //Check CSRF token on form submission
        $this->beforeFilter('Sentinel\csrf', ['on' => ['post', 'put', 'delete']]);

        // Set up Auth Filters
        $this->beforeFilter('Sentinel\auth', ['only' => ['show', 'edit', 'update']]);
    }

    /**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
        // Get the user
        $user = $this->userRepository->retrieveById(Session::get('userId'));

        return $this->viewFinder('Sentinel::users.show', ['user' => $user]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit()
	{
        // Get the user
        $user = $this->userRepository->retrieveById(Session::get('userId'));

        // Get all available groups
        $groups = $this->groupRepository->all();

        return $this->viewFinder('Sentinel::users.edit', [
            'user' => $user,
            'groups' => $groups
        ]);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update()
	{
        // Gather Input
        $data = Input::all();
        $data['id'] = Session::get('userId');

        // Validate form data
        $this->userUpdateForm->validate($data);

        // Attempt to update the user
        $result = $this->userRepository->update($data);

        // Done!
        return $this->redirectViaResponse('profile.update', $result);
	}

    /**
     * Process a password change request
     *
     * @return Redirect
     */
    public function changePassword()
    {
        // Gather input
        $data       = Input::all();
        $data['id'] = Session::get('userId');

        // Validate form Data
        $this->changePasswordForm->validate($data);

        // Grab the current user
        $user = $this->userRepository->getUser();

        // Change the User's password
        $result = ($user->hasAccess('admin') ? $this->userRepository->changePasswordWithoutCheck($data) : $this->userRepository->changePassword($data));

        // Was the change successful?
        if (! $result->isSuccessful())
        {
            Session::flash('error', $result->getMessage());
            return Redirect::back();
        }
        return $this->redirectViaResponse('profile.change.password', $result);
    }

}
