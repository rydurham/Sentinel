<?php

use Sentinel\Models\User;
use Illuminate\Support\Facades\DB;

class SentinelUserModelTests extends SentinelTestCase
{
    public function test_user_status_attribute_can_be_active()
    {
        $user = Sentry::findUserByLogin('user@user.com');

        $this->assertNull($user->throttle);
        $this->assertEquals('Active', $user->status);
    }

    public function test_user_status_attribute_can_be_inactive()
    {
        // Fetch the user repository
        $userRepository =  app()->make('Sentinel\Repositories\User\SentinelUserRepositoryInterface');

        // Create a new user that has not been activated
        $userResponse = $userRepository->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha'
        ]);

        $user = $userResponse->getPayload()['user'];

        $this->assertNull($user->throttle);
        $this->assertEquals('Not Active', $user->status);
    }

    public function test_user_status_attribute_can_be_suspended()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Fetch the User Repository
        $userRepository =  app()->make('Sentinel\Repositories\User\SentinelUserRepositoryInterface');

        // Suspend the user
        $result = $userRepository->suspend($user->id, 15);

        $this->assertInstanceOf('Cartalyst\Sentry\Throttling\Eloquent\Throttle', $user->throttle);
        $this->assertEquals('Suspended', $user->status);
    }

    public function test_user_status_attribute_can_be_banned()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Fetch the User Repository
        $userRepository =  app()->make('Sentinel\Repositories\User\SentinelUserRepositoryInterface');

        // Suspend the user
        $result = $userRepository->ban($user->id);

        $this->assertInstanceOf('Cartalyst\Sentry\Throttling\Eloquent\Throttle', $user->throttle);
        $this->assertEquals('Banned', $user->status);
    }
}
