<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SentinelAddUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add the username to the users table
        Schema::table('users', function ($table) {
            $table->string('username')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove username from the users table
        Schema::table('users', function ($table) {
            $table->dropColumn('username');
        });
    }
}
