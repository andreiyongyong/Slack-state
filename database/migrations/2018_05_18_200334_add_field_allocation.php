<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAllocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocation', function (Blueprint $table) {
            $table->integer('is_delete', 4);
            $table->timestamp('create_at');
            $table->timestamp('update_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allocation', function (Blueprint $table) {
            $table->dropColumn('is_delete');
            $table->dropColumn('create_at');
            $table->dropColumn('update_at');
        });
    }
}
