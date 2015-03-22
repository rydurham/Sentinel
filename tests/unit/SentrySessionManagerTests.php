<?php

use Sentinel\Managers\Session\SentrySessionManager;

/**
 * Class SentryUserTest
 * Test the methods in the SentryUser repository class
 * /src/Sentinel/Repo/User/SentryUser
 */
class SentrySessionTests extends Orchestra\Testbench\TestCase
{
    /*
     * These tests make use of the Orchestra Test Bench Package: https://github.com/orchestral/testbench
     */

    // The class being tested
    protected $repo;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->repo = app()->make('Sentinel\Repositories\Session\SentinelSessionRepositoryInterface');
    }

    /**
     * Destroy the test environment
     */
    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/../_data/db.sqlite',
            'prefix'   => '',
        ]);

        // Prepare the sqlite database
        // http://www.chrisduell.com/blog/development/speeding-up-unit-tests-in-php/
        exec('cp ' . __DIR__ . '/../_data/prep.sqlite ' . __DIR__ . '/../_data/db.sqlite');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Sentinel\SentinelServiceProvider',
        ];
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
        $this->assertInstanceOf('Sentinel\Repositories\Session\SentrySessionRepository', $this->repo);
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
    public function testCreatingSession()
    {
        // This is the code we are testing
        $result = $this->repo->store([
            'email' => 'user@user.com',
            'password' => 'sentryuser'
        ]);

        // Assertions
        $this->assertTrue($result->isSuccessful());
    }



}