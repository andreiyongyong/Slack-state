<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('level')->default(11);
            $table->tinyInteger('type')->default(2);
            $table->string('image') -> default('');
            $table->boolean('called') -> default(0);
            $table->string('stack') -> default('');
            $table->string('skypeid') -> default('');
            $table->string('room') -> default('');
            $table->integer('country') -> default(0);
            $table->integer('age') -> default(0);
            $table->string('notes') -> default('');
            $table->boolean('approved') -> default(0);
            $table->string('time_doctor_email') -> default('');
            $table->string('time_doctor_password') -> default(''); 
        });
    }    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('level');
            $table->dropColumn('type');
        });
    }
}
