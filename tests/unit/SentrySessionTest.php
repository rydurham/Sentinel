<?php

use Cartalyst\Sentry\Sentry;
use Sentinel\Repo\Session\SentrySession;

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
        $this->configMock     = Mockery::mock('Illuminate\Config\Repository');
        $this->sentry         = new Cartalyst\Sentry\Sentry;
        $this->repo           = new SentrySession($this->sentry);
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
        $this->assertInstanceOf('Sentinel\Repo\Session\SentrySession', $this->repo);
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
        // This is the code we are testing
        $result = $this->repo->store([
            'email' => 'user@user.com',
            'password' => 'sentryuser'
        ]);

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertInstanceOf('Cartalyst\Sentry\Users\Eloquent\User', $result['user']);
    }



}