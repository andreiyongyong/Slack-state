<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->dropColumn('time_doctor_email');
            $table->dropColumn('time_doctor_password');
            $table->dropColumn('channel_id');
            $table->dropColumn('room');
            $table->dropColumn('age');
            $table->dropColumn('country');
            $table->dropColumn('notes');
            $table->dropColumn('called');
            $table->dropColumn('approved');
            $table->dropColumn('skypeid');
            $table->dropColumn('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->string('time_doctor_email');
            $table->string('time_doctor_password');
            $table->string('channel_id');
            $table->string('room');
            $table->Integer('age');
            $table->string('country');
            $table->string('notes');
            $table->Integer('called');
            $table->Integer('approved');
            $table->string('skypeid');
            $table->string('project_id');
        });
    }
}
