<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlackChatPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_chat_pair', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('workspace_id_1');
            $table->integer('user_id_1');
            $table->integer('admin_id_1');
            $table->integer('workspace_id_2');
            $table->integer('user_id_2');
            $table->integer('admin_id_2');
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
        Schema::dropIfExists('slack_chat_pair');
    }
}
