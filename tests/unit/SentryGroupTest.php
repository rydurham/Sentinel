<?php
use Sentinel\Repo\Group\SentryGroup;
use Cartalyst\Sentry\Sentry;
use Sentinel\Repo\RepoAbstract;
use Illuminate\Config\Repository;
use Illuminate\Events\Dispatcher;

/**
 * Class SentryUserTest
 * Test the methods in the SentryUser repository class
 * /src/Sentinel/Repo/User/SentryUser
 */
class SentryGroupTest extends \Codeception\TestCase\Test
{
    protected $sentinelConfiguration = [];
    protected $configMock;
    protected $dispatcherMock;
    protected $sentry;

    /******************************************************************************************************************
     * Test Preparation
     ******************************************************************************************************************/
    protected function _before()
    {
        $this->dispatcherMock = Mockery::mock('Illuminate\Events\Dispatcher');
        $this->configMock     = Mockery::mock('Illuminate\Config\Repository');
        $this->sentry         = new Cartalyst\Sentry\Sentry;
        $this->repo           = new SentryGroup($this->sentry);
    }

    protected function _after()
    {
    }

    /******************************************************************************************************************
     * Tests
     ******************************************************************************************************************/

    /**
     * Test the instantiation of the Sentinel SentryUser repository
     */
    function testRepoInstantiation()
    {
        // Test that we are able to properly instantiate the SentryUser object for testing
        $this->assertInstanceOf('Sentinel\Repo\Group\SentryGroup', $this->repo);
    }

    /**
     * Test that the seed data exists and is reachable
     */
    public function testDatabaseSeeds()
    {
        // Double check that the test data is present and correctly seeded
        $this->tester->seeRecord('users', array('email' => 'user@user.com'));
        $this->tester->seeRecord('users', array('email' => 'admin@admin.com'));
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

        $group = $this->sentry->findGroupByName('Prozorovs');

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertInstanceOf('Cartalyst\Sentry\Groups\Eloquent\Group', $group);
        $this->assertArrayHasKey('family', $group->getPermissions());
        $this->assertArrayNotHasKey('admin', $group->getPermissions());
        $this->tester->seeRecord('groups', array(
            'name'   => 'Prozorovs',
        ));
    }

    /**
     * Test the creation of a user using the default configuration options
     */
    public function testSavingGroupAlternatePermissionsMethod()
    {
        // This is the code we are testing
        $result = $this->repo->store([
            'name' => 'Prozorovs',
            'adminPermissions' => 1,
            'userPermissions' => 1
        ]);

        $group = $this->sentry->findGroupByName('Prozorovs');

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertInstanceOf('Cartalyst\Sentry\Groups\Eloquent\Group', $group);
        $this->assertArrayHasKey('admin', $group->getPermissions());
        $this->assertArrayHasKey('users', $group->getPermissions());
        $this->tester->seeRecord('groups', array(
            'name'   => 'Prozorovs',
        ));
    }

    public function testUpdatingGroup()
    {
        // Find the group we will edit
        $group = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->update([
            'id' => $group->id,
            'name' => 'Prozorovs',
            'permissions' => ['admin' => 1, 'users' => 0]
        ]);

        // Pull the group details again
        $group = $this->sentry->findGroupById($group->id);

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertEquals('Prozorovs', $group->name);
        $this->assertArrayHasKey('admin', $group->getPermissions());
        $this->assertArrayNotHasKey('users', $group->getPermissions());
    }

    public function testUpdatingGroupAlternatePermissionsMethod()
    {
        // Find the group we will edit
        $group = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->update([
            'id' => $group->id,
            'name' => 'Prozorovs',
            'adminPermissions' => 1,
        ]);

        // Pull the group details again
        $group = $this->sentry->findGroupById($group->id);

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertEquals('Prozorovs', $group->name);
        $this->assertArrayHasKey('admin', $group->getPermissions());
        $this->assertArrayNotHasKey('users', $group->getPermissions());
    }

    public function testDestroyGroup()
    {
        // Find the group we will remove from storage
        $group = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->destroy($group->id);

        // Assertions
        $this->assertTrue($result);
        $this->tester->dontSeeRecord('groups', [
            'name' => 'Users'
        ]);
    }

    public function testRetrieveGroupById()
    {
        // Find the group we will use for reference
        $reference = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $group = $this->repo->byId($reference->id);

        // Assertions
        $this->assertInstanceOf('Cartalyst\Sentry\Groups\Eloquent\Group', $group);
        $this->assertEquals('Users', $group->name);
    }

    public function testRetrieveGroupByName()
    {
        // Find the group we will use for reference
        $reference = $this->sentry->findGroupById(1);

        // This is the code we are testing
        $group = $this->repo->byName($reference->name);

        // Assertions
        $this->assertInstanceOf('Cartalyst\Sentry\Groups\Eloquent\Group', $group);
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