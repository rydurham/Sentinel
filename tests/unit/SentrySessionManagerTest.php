<?php

use Sentinel\Managers\Session\SentrySessionManager;

/**
 * Class SentryUserTest
 * Test the methods in the SentryUser repository class
 * /src/Sentinel/Repo/User/SentryUser
 */
class SentrySessionTest extends \Codeception\TestCase\Test
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
        $this->repo           = new SentrySessionManager($this->sentry, $this->dispatcherMock);
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
        $this->assertInstanceOf('Sentinel\Managers\Session\SentrySessionManager', $this->repo);
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
    public function testCreatingSession()
    {
        // Mock the Event::fire() call
        $this->dispatcherMock->shouldReceive('fire')
                             ->with('sentinel.user.login', \Mockery::hasKey('user'))->once();

        // This is the code we are testing
        $result = $this->repo->store([
            'email' => 'user@user.com',
            'password' => 'sentryuser'
        ]);

        // Assertions
        $this->assertTrue($result->isSuccessful());
    }



}