<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->increments('id', true);
            $table->integer('user_id');
            $table->string('stack',100);
            $table->string('skypeid',100);
            $table->string('room',100);
            $table->string('country',100);
            $table->tinyInteger('age');
            $table->string('time_doctor_email');
            $table->string('time_doctor_password');
            $table->string('notes');
            $table->tinyInteger('called')->default(0);
            $table->tinyInteger('approved')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}
