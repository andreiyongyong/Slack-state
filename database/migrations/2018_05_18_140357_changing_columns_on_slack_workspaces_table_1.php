<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangingColumnsOnSlackWorkspacesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slack_workspaces', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('workspace_number');
            $table->string('id_');
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
            $table->string('name');
            $table->dropColumn('workspace_number');
            $table->dropColumn('id_');
        });
    }
}
