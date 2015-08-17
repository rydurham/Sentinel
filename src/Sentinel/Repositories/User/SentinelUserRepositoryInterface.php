<?php

namespace Sentinel\Repositories\User;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Sentinel\DataTransferObjects\BaseResponse;
use Sentinel\Models\User;

interface SentinelUserRepositoryInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param $data
     *
     * @return BaseResponse
     */
    public function store($data);

    /**
     * Update the specified resource in storage.
     *
     * @param $data
     *
     * @return BaseResponse
     */
    public function update($data);

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return BaseResponse
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
     * @return Bool
     */
    public function activate($id, $code);

    /**
     * Resend the activation email to the specified email address
     *
     * @param  Array $data
     *
     * @return BaseResponse
     */
    public function resend($data);

    /**
     * The user has requested a password reset
     *
     * @param $email
     *
     * @return Bool
     *
     */
    public function triggerPasswordReset($email);

    /**
     * Validate a password reset link
     *
     * @param $id
     * @param $code
     *
     * @return BaseResponse
     */
    public function validateResetCode($id, $code);

    /**
     * Process the password reset request
     *
     * @param  int $id
     * @param  string $code
     *
     * @return BaseResponse
     */
    public function resetPassword($id, $code, $password);

    /**
     * Process a change password request.
     *
     * @return BaseResponse
     */
    public function changePassword($data);

    /**
     * Change a user's password without checking their old password first
     *
     * @param $data
     *
     * @return BaseResponse
     */
    public function changePasswordWithoutCheck($data);

    /**
     * Process a change password request.
     *
     * @return BaseResponse
     */
    public function changeGroupMemberships($userId, $groups);

    /**
     * Suspend a user
     *
     * @param  int $id
     *
     * @return BaseResponse
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
    public function validateCredentials(Authenticatable $user, array $credentials);
}
