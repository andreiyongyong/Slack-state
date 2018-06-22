<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpworkTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upwork', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->integer('country');
            $table->date('date');
            $table->string('rising_talent');
            $table->string('test');
            $table->date('bid_date');
            $table->string('lancer_type');
            $table->string('upwork_name');
            $table->string('upwork_id');
            $table->string('email');
            $table->string('password');
            $table->string('security_question');
            $table->string('security_answer');
            $table->string('series'); 
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
        //
    }
}
