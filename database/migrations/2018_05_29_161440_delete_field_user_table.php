<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteFieldUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stack');
            $table->dropColumn('skypeid');
            $table->dropColumn('notes');
            $table->dropColumn('approved');
            $table->dropColumn('called');
            $table->dropColumn('room');
            $table->string('country')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stack');
            $table->string('skypeid');
            $table->string('notes');
            $table->string('approved');
            $table->string('called');
            $table->string('room');
        });
    }
}
