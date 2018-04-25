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
            $table->string('image');
            $table->boolean('called');
            $table->string('stack');
            $table->string('skypeid');
            $table->string('room');
            $table->integer('country');
            $table->integer('age');
            $table->string('notes');
            $table->boolean('approved');
            $table->string('time_doctor_email');
            $table->string('time_doctor_password'); 
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
