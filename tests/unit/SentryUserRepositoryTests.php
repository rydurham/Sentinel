<?php

use Illuminate\Support\Facades\DB;

class SentryUserRepositoryTests extends SentinelTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->repo = app()->make('Sentinel\Repositories\User\SentinelUserRepositoryInterface');
    }

    /**
     * Test the instantiation of the Sentinel SentryUser repository
     */
    public function testRepoInstantiation()
    {
        // Test that we are able to properly instantiate the SentryUser object for testing
        $this->assertInstanceOf('Sentinel\Repositories\User\SentryUserRepository', $this->repo);
    }

    /**
     * Test that the seed data exists and is reachable
     */
    public function testDatabaseSeeds()
    {
        // Check that the test data is present and correctly seeded
        $user = DB::table('users')->where('email', 'user@user.com')->first();
        $this->assertEquals('user@user.com', $user->email);
    }

    /**
     * Test the creation of a user using the default configuration options
     */
    public function testSavingUser()
    {
        // Explicitly set the allow usernames config option to true
        app()['config']->set('sentinel.allow_usernames', true);

        // Explicily disable additional user fields
        app()['config']->set('sentinel.additional_user_fields', []);

        // This is the code we are testing
        $result = $this->repo->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha'
        ]);

        // Grab the "Users" group object for assertions
        $usersGroup = Sentry::findGroupByName('Users');

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $this->assertFalse($result->getPayload()['activated']);
        $this->assertTrue($result->getPayload()['user']->inGroup($usersGroup));
        $testUser = DB::table('users')
            ->where('username', 'theviolinist')
            ->where('email', 'andrei@prozorov.net')
            ->where('first_name', null)
            ->where('last_name', null)
            ->first();
        $this->assertEquals('andrei@prozorov.net', $testUser->email);
    }

    /**
     * Test the creation of a user that should be activated upon creation
     */
    public function testSavingActivatedUser()
    {
        // This is the code we are testing
        $result = $this->repo->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha',
            'activate'   => true
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $this->assertTrue($result->getPayload()['activated']);
        $testUser = DB::table('users')
            ->where('username', 'theviolinist')
            ->where('email', 'andrei@prozorov.net')
            ->where('first_name', 'Andrei')
            ->where('last_name', 'Prozorov')
            ->where('activated', 1)
            ->first();
        $this->assertEquals('andrei@prozorov.net', $testUser->email);
    }

    /**
     * Test the creation of a user without the use of a username
     */
    public function testSavingUserWithoutUsername()
    {
        // Explicitly set the 'allow usernames' config option to false
        app()['config']->set('sentinel.allow_usernames', false);

        // This is the code we are testing
        $result = $this->repo->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha'
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $this->assertFalse($result->getPayload()['activated']);
        $testUser = DB::table('users')
            ->where('username', null)
            ->where('email', 'andrei@prozorov.net')
            ->first();
        $this->assertEquals('andrei@prozorov.net', $testUser->email);
    }

    /**
     * Test the creation of users with additional user fields
     */
    public function testSavingUserWithAdditionalData()
    {
        // Explicitly set the 'allow usernames' config option to false
        app()['config']->set('sentinel.allow_usernames', false);

        // Explicitly set the 'additional user fields'
        app()['config']->set('sentinel.additional_user_fields', [
                'first_name' => 'alpha_spaces',
                'last_name'  => 'alpha_spaces'
        ]);

        // This is the code we are testing
        $result = $this->repo->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha'
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $this->assertFalse($result->getPayload()['activated']);
        $testUser = DB::table('users')
            ->where('email', 'andrei@prozorov.net')
            ->where('first_name', 'Andrei')
            ->where('last_name', 'Prozorov')
            ->first();
        $this->assertEquals('andrei@prozorov.net', $testUser->email);
    }

    /**
     * Test updating an existing user
     */
    public function testUpdatingUser()
    {
        // Explicily disable additional user fields
        app()['config']->set('sentinel.additional_user_fields', []);
        
        // Find the user we are going to update
        $user = Sentry::findUserByLogin('user@user.com');

        // This is the code we are testing
        $result = $this->repo->update([
            'id'         => $user->id,
            'first_name' => 'Irina',
            'last_name'  => 'Prozorova',
            'username'   => 'muscovite04',
            'email'      => 'irina@prozorov.net'
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $user);
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $testUser = DB::table('users')
            ->where('id', $user->id)
            ->where('username', 'muscovite04')
            ->where('email', 'irina@prozorov.net')
            ->first();
        $this->assertEquals('irina@prozorov.net', $testUser->email);
    }

    /**
     * Update a user without referencing the username
     */
    public function testUpdatingUserWithNoUsername()
    {
        // Explicily disable additional user fields
        app()['config']->set('sentinel.additional_user_fields', []);

        // Find the user we are going to update
        $user = Sentry::findUserByLogin('user@user.com');

        // Find the admin user we are going to impersonate
        $admin = Sentry::findUserByLogin('admin@admin.com');
        Sentry::setUser($admin);

        // This is the code we are testing
        $result = $this->repo->update([
            'id'         => $user->id,
            'first_name' => 'Irina',
            'last_name'  => 'Prozorova',
            'email'      => 'irina@prozorov.net'
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $user);
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $testUser = DB::table('users')
            ->where('id', $user->id)
            ->where('first_name', null)
            ->where('last_name', null)
            ->where('username', '')
            ->where('email', 'irina@prozorov.net')
            ->first();
        $this->assertEquals('irina@prozorov.net', $testUser->email);
    }

    /**
     * Update a user without referencing the username
     */
    public function testUpdatingUserWithAdditionalData()
    {
        // Explicitly set the 'additional user fields'
        app()['config']->set('sentinel.additional_user_fields', [
            'first_name' => 'alpha_spaces',
            'last_name'  => 'alpha_spaces'
        ]);

        // Find the user we are going to update
        $user = Sentry::findUserByLogin('user@user.com');

        // Find the admin user we are going to impersonate
        $admin = Sentry::findUserByLogin('admin@admin.com');
        Sentry::setUser($admin);

        // This is the code we are testing
        $result = $this->repo->update([
            'id'         => $user->id,
            'first_name' => 'Irina',
            'last_name'  => 'Prozorova',
            'email'      => 'irina@prozorov.net'
        ]);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $user);
        $this->assertInstanceOf('Sentinel\Models\User', $result->getPayload()['user']);
        $this->assertTrue($result->isSuccessful());
        $testUser = DB::table('users')
            ->where('id', $user->id)
            ->where('first_name', 'Irina')
            ->where('last_name', 'Prozorova')
            ->where('email', 'irina@prozorov.net')
            ->first();
        $this->assertEquals('irina@prozorov.net', $testUser->email);
    }

    /**
     * Test deleting a user from storage
     */
    public function testDestroyUser()
    {
        // Find the user we are going to delete
        $user = Sentry::findUserByLogin('user@user.com');

        // This is the code we are testing
        $this->repo->destroy($user->id);

        // Assertions
        $this->assertTrue(DB::table('users')->where('email', 'user@user.com')->count() == 0);
    }

    /**
     * Test user activation
     */
    public function testActivatingUser()
    {
        // Explicitly set the 'allow usernames' config option to false
        app()['config']->set('sentinel.allow_usernames', false);

        // Explicily disable additional user fields
        app()['config']->set('sentinel.additional_user_fields', []);

        // Create a new user that is not activated
        $userResponse = $this->repo->store([
            'first_name' => 'Andrei',
            'last_name'  => 'Prozorov',
            'username'   => 'theviolinist',
            'email'      => 'andrei@prozorov.net',
            'password'   => 'natasha'
        ]);

        $user = $userResponse->getPayload()['user'];

        // This is the code we are testing
        $result = $this->repo->activate($user->id, $user->GetActivationCode());

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->assertTrue(DB::table('users')->where('email', 'andrei@prozorov.net')->where('activated', 1)->count() == 1);
    }

    public function testChangeUserPassword()
    {
        // Find the user we are going to update
        $user = Sentry::findUserByLogin('user@user.com');

        // This is the code we are testing
        $result = $this->repo->changePassword([
            'id'          => $user->id,
            'oldPassword' => 'sentryuser',
            'newPassword' => 'sergeyevna'
        ]);

        // Pull the user data again
        $user = Sentry::findUserByLogin('user@user.com');

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->assertTrue($user->checkHash('sergeyevna', $user->getPassword()));
    }

    /**
     * @expectedException \Cartalyst\Sentry\Throttling\UserSuspendedException
     */
    public function testSuspendUser()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Prepare the Throttle Provider
        $throttleProvider = Sentry::getThrottleProvider();

        // This is the code we are testing
        $result = $this->repo->suspend($user->id, 15);

        // Ask the Throttle Provider to gather information for this user
        $throttle = $throttleProvider->findByUserId($user->id);

        // Check the throttle status.  This will throw a 'user suspended' exception.
        $throttle->check();
    }

    /**
     * Test removing a user suspension
     */
    public function testUnsuspendUser()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Prepare the Throttle Provider
        $throttleProvider = Sentry::getThrottleProvider();

        // Suspend the user
        $this->repo->suspend($user->id, 15);

        // This is the code we are testing
        $result = $this->repo->unsuspend($user->id);

        // Check the throttle status.  This will throw a 'user suspended' exception.
        $throttle = $throttleProvider->findByUserId($user->id);

        // Check the throttle status.  This should do nothing
        $throttle->check();

        // Assertions
        $this->assertTrue($result->isSuccessful());
    }

    /**
     * @expectedException \Cartalyst\Sentry\Throttling\UserBannedException
     */
    public function testBanUser()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Prepare the Throttle Provider
        $throttleProvider = Sentry::getThrottleProvider();

        // This is the code we are testing
        $result = $this->repo->ban($user->id);

        // Ask the Throttle Provider to gather information for this user
        $throttle = $throttleProvider->findByUserId($user->id);

        // Check the throttle status.  This will throw a 'user banned' exception.
        $throttle->check();
    }

    public function testUnbanUser()
    {
        // Find the user we are going to suspend
        $user = Sentry::findUserByLogin('user@user.com');

        // Prepare the Throttle Provider
        $throttleProvider = Sentry::getThrottleProvider();

        // Ban the user
        $this->repo->ban($user->id);

        // This is the code we are testing
        $result = $this->repo->unban($user->id);

        // Ask the Throttle Provider to gather information for this user
        $throttle = $throttleProvider->findByUserId($user->id);

        // Check the throttle status.  This should do nothing.
        $throttle->check();

        // Assertions
        $this->assertTrue($result->isSuccessful());
    }

    public function testRetrieveUserById()
    {
        // This is the code we are testing
        $user = $this->repo->retrieveById(1);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $user);
        $this->assertEquals('admin@admin.com', $user->email);
    }

    public function testRetrieveUserByEmail()
    {
        // This is the code we are testing
        $user = $this->repo->retrieveByCredentials(['email' => 'admin@admin.com']);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\User', $user);
        $this->assertEquals(1, $user->id);
    }

    public function testRetrieveAllUsers()
    {
        // This is the code we are testing
        $users = $this->repo->all();

        // Assertions
        $this->assertTrue(is_array($users));
        $this->assertEquals(2, count($users));
    }
}
