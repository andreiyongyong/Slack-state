<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFieldStatusOnMarket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('market', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('market', function (Blueprint $table) {
            $table->enum('status', ['done', 'exist']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('market', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('market', function (Blueprint $table) {
            $table->enum('status', ['done', 'updated', 'pending']);
        });
    }
}
