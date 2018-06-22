<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForuminstanceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foruminstance', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->integer('forum_mid');
            $table->integer('userid');
            $table->timestamp('reply_time');
            $table->string('answer');  
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
