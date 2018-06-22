<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlackWorkspaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slack_workspaces', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('token', 255);
            $table->string('name', 255);
            $table->string('workspace_id', 255);
            $table->string('domain', 255);
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
        Schema::dropIfExists('slack_workspaces');
    }
}
