<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangingColumnsOnSlackWokspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slack_workspaces', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('id_');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slack_workspaces', function (Blueprint $table) {
            $table->string('token', 255);
            $table->string('id_', 255);
        });
    }
}
