<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources-management', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->string('title' , 100);
            $table->string('url' );
            $table->text('content');
            $table->tinyInteger('type');
            $table->tinyInteger('level');
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
        Schema::dropIfExists('resources-management');
    }
}
