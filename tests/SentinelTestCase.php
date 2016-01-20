<?php

/**
 * Created by Ryan C. Durham
 * Email: ryan@stagerightlabs.com
 * Project: sentinel2
 * Date: 6/11/2015
 */
class SentinelTestCase extends Orchestra\Testbench\TestCase
{
    /*
     * These tests make use of the Orchestra Test Bench Package: https://github.com/orchestral/testbench
     */

    // The class being tested
    protected $repo;

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
            'database' => __DIR__ . '/_data/db.sqlite',
            'prefix'   => '',
        ]);
        $app['config']->set('mail.driver', 'log');
        $app['config']->set('mail.from', ['from' => 'noreply@example.com', 'name' => null]);

        // Prepare the sqlite database
        // http://www.chrisduell.com/blog/development/speeding-up-unit-tests-in-php/
        exec('cp ' . __DIR__ . '/_data/prep.sqlite ' . __DIR__ . '/_data/db.sqlite');
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
}
