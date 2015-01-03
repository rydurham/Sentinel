<?php namespace Sentinel\Repositories\User;

use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Sentinel\Models\User;

interface SentinelUserRepositoryInterface {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data);
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id);

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id);

	/**
	 * Return all the registered users
	 *
	 * @return Collection
	 */
	public function all();

	/**
	 * Return the currently active user
	 *
	 * @return User
	 */
	public function getUser();

	/**
	 * Attempt activation for the specified user
	 *
	 * @param  int $id
	 * @param  string $code
	 *
	 * @return bool
	 */
	public function activate( $id, $code);

	/**
	 * Resend the activation email to the specified email address
	 *
	 * @param  Array $data
	 *
	 * @return Response
	 */
	public function resend($data);

	/**
	 * Handle a password reset request
	 *
	 * @param  Array $data
	 *
	 * @return Bool
	 */
	public function forgotPassword($data);

	/**
	 * Process the password reset request
	 *
	 * @param  int $id
	 * @param  string $code
	 *
	 * @return Array
	 */
	public function resetPassword($id, $code);

	/**
	 * Process a change password request.
	 * @return Array $data
	 */
	public function changePassword($data);

	/**
	 * Suspend a user
	 *
	 * @param  int $id
	 * @param  int $minutes
	 *
	 * @return Array
	 */
	public function suspend($id);

	/**
	 * Remove a users' suspension.
	 *
	 * @param  [type] $id [description]
	 *
	 * @return [type]     [description]
	 */
	public function unSuspend($id);

	/**
	 * Ban a user
	 *
	 * @param  int $id
	 *
	 * @return Array
	 */
	public function ban($id);

	/**
	 * Remove a users' ban
	 *
	 * @param  int $id
	 *
	 * @return Array
	 */
	public function unBan($id);

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed $identifier
	 *
	 * @return \Illuminate\Auth\UserInterface|null
	*/
	public function retrieveById($identifier);

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array $credentials
	 *
	 * @return \Illuminate\Auth\UserInterface|null
	*/
	public function retrieveByCredentials(array $credentials);

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Auth\UserInterface $user
	 * @param  array                          $credentials
	 *
	 * @return bool
	 */
	public function validateCredentials( UserInterface $user, array $credentials);


}
