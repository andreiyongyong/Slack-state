<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldRepositoryallocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repository_allocation', function (Blueprint $table) {
            $table->string('git_username', 20);
            $table->string('invite_id', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repository_allocation', function (Blueprint $table) {
            $table->dropColumn('git_username');
            $table->dropColumn('invite_id');
        });
    }
}
