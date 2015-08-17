<?php

class SentryGroupRepositoryTests extends SentinelTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->repo = app()->make('Sentinel\Repositories\Group\SentinelGroupRepositoryInterface');
    }
    
    /**
     * Test the instantiation of the Sentinel SentryUser repository
     */
    public function testRepoInstantiation()
    {
        // Test that we are able to properly instantiate the SentryUser object for testing
        $this->assertInstanceOf('Sentinel\Repositories\Group\SentryGroupRepository', $this->repo);
    }

    /**
     * Test that the seed data exists and is reachable
     */
    public function testDatabaseSeeds()
    {
        // Check that the test data is present and correctly seeded
        $user = \DB::table('users')->where('email', 'user@user.com')->first();
        $this->assertEquals('user@user.com', $user->email);
    }

    /**
     * Test the creation of a user using the default configuration options
     */
    public function testSavingGroup()
    {
        // This is the code we are testing
        $result = $this->repo->store([
            'name' => 'Prozorovs',
            'permissions' => ['family' => 1, 'admin' => 0]
        ]);

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->assertInstanceOf('Sentinel\Models\Group', $result->getPayload()['group']);
        $this->assertArrayHasKey('family', $result->getPayload()['group']->getPermissions());
        $this->assertArrayNotHasKey('admin', $result->getPayload()['group']->getPermissions());

        $group = \DB::table('groups')->where('name', 'Prozorovs')->first();
        $this->assertEquals('Prozorovs', $group->name);
    }

    public function testUpdatingGroup()
    {
        // Find the group we will edit
        $group = Sentry::findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->update([
            'id' => $group->id,
            'name' => 'Prozorovs',
            'permissions' => ['admin' => 1, 'users' => 0]
        ]);

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->assertEquals('Prozorovs', $result->getPayload()['group']->name);
        $this->assertArrayHasKey('admin', $result->getPayload()['group']->getPermissions());
        $this->assertArrayNotHasKey('users', $result->getPayload()['group']->getPermissions());
    }

    public function testDestroyGroup()
    {
        // Find the group we will remove from storage
        $group = Sentry::findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->destroy($group->id);

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->assertFalse(\DB::table('groups')->where('name', 'Users')->count() > 0);
    }

    public function testRetrieveGroupById()
    {
        // Find the group we will use for reference
        $reference = Sentry::findGroupByName('Users');

        // This is the code we are testing
        $group = $this->repo->retrieveById($reference->id);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\Group', $group);
        $this->assertEquals('Users', $group->name);
    }

    public function testRetrieveGroupByName()
    {
        // Find the group we will use for reference
        $reference = Sentry::findGroupById(1);

        // This is the code we are testing
        $group = $this->repo->retrieveByName($reference->name);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\Group', $group);
        $this->assertEquals(1, $group->id);
    }

    public function testRetrieveAllGroups()
    {
        // This is the code we are testing
        $groups = $this->repo->all();

        // Assertions
        $this->assertTrue(is_array($groups));
        $this->assertEquals(2, count($groups));
    }
}
