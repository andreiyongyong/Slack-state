<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskcollocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_allocation', function (Blueprint $table) {
            $table->increments('id' ,true);
            $table->integer('user_id')->nullable();
            $table->integer('task_id', 50)->nullable();
            $table->tinyInteger('is_delete');
            $table->timestamps('create_at');
            $table->timestamps('update_at');
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
        Schema::dropIfExists('task_allocation');
    }
}
