<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('password') -> default('')->change();
            $table->string('lastname') -> default('')->change();
            $table->string('firstname') -> default('')->change();
            $table->string('image') -> default('')->change();
            $table->boolean('called') -> default(0)->change();
            $table->string('stack') -> default('')->change();
            $table->string('skypeid') -> default('')->change();
            $table->string('room') -> default('')->change();
            $table->integer('country') -> default(0)->change();
            $table->integer('age') -> default(0)->change();
            $table->string('notes') -> default('')->change();
            $table->boolean('approved') -> default(0)->change();
            $table->string('time_doctor_email') -> default('')->change();
            $table->string('time_doctor_password') -> default('')->change(); 
            $table->string('slack_user_id', 255) -> default('')->change();
            $table->string('workspace_id', 255) -> default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
