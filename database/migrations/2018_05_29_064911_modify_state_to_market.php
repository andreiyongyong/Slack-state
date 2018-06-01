<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStateToMarket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void\Migration;

     */
    public function up()
    {
        // Schema::table('market', function($table) {
        //     $table->enum('status', ['pending', 'updated', 'done']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('market', function (Blueprint $table) {
        //     $table->dropColumn('status');
        // });
    }
}
