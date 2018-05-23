<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFieldProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->date('meet_time')->change();
            $table->float('price', 10, 2)->nullable()->change();
            $table->integer('developer')->nullable()->change();
            $table->integer('mode')->nullable()->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project', function (Blueprint $table) {
            $table->dropColumn('meet_time');
            $table->dropColumn('price');
            $table->dropColumn('developer');
            $table->dropColumn('mode');

        });
    }
}
