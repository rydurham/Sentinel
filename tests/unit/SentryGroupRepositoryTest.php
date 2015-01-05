<?php
use Sentinel\Repositories\Group\SentryGroupRepository;


/**
 * Class SentryUserTest
 * Test the methods in the SentryUser repository class
 * /src/Sentinel/Repo/User/SentryUser
 */
class SentryGroupRepositoryTest extends \Codeception\TestCase\Test
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
        $this->sentry         = $this->tester->grabService('sentry');
        $this->repo           = new SentryGroupRepository($this->sentry, $this->dispatcherMock);
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
        $this->assertInstanceOf('Sentinel\Repositories\Group\SentryGroupRepository', $this->repo);
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
        // Mock the Event::fire() calls
        $this->dispatcherMock->shouldReceive('fire')
                             ->with('sentinel.group.created', \Mockery::hasKey('group'))->once();

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
        $this->tester->seeRecord('groups', array(
            'name'   => 'Prozorovs',
        ));
    }

    public function testUpdatingGroup()
    {
        // Mock the Event::fire() calls
        $this->dispatcherMock->shouldReceive('fire')
                             ->with('sentinel.group.updated', \Mockery::hasKey('group'))->once();

        // Find the group we will edit
        $group = $this->sentry->findGroupByName('Users');

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
        // Mock the Event::fire() calls
        $this->dispatcherMock->shouldReceive('fire')
                             ->with('sentinel.group.destroyed', \Mockery::hasKey('group'))->once();

        // Find the group we will remove from storage
        $group = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $result = $this->repo->destroy($group->id);

        // Assertions
        $this->assertTrue($result->isSuccessful());
        $this->tester->dontSeeRecord('groups', [
            'name' => 'Users'
        ]);
    }

    public function testRetrieveGroupById()
    {
        // Find the group we will use for reference
        $reference = $this->sentry->findGroupByName('Users');

        // This is the code we are testing
        $group = $this->repo->retrieveById($reference->id);

        // Assertions
        $this->assertInstanceOf('Sentinel\Models\Group', $group);
        $this->assertEquals('Users', $group->name);
    }

    public function testRetrieveGroupByName()
    {
        // Find the group we will use for reference
        $reference = $this->sentry->findGroupById(1);

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