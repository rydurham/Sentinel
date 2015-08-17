<?php

use Illuminate\Database\Seeder;

class SentryUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Sentry::getUserProvider()->create(array(
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => 'sentryadmin',
            'activated' => 1,
        ));

        Sentry::getUserProvider()->create(array(
            'email'    => 'user@user.com',
            'username' => '',
            'password' => 'sentryuser',
            'activated' => 1,
        ));
    }
}
