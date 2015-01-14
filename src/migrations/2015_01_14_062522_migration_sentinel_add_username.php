<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationSentinelAddUsername extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// If there is not already a username column on the users table, add it.
        if (! Schema::hasColumn('users', 'username'))
        {
            Schema::table('users', function($table)
            {
                $table->string('username')->nullable()->unique();
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
