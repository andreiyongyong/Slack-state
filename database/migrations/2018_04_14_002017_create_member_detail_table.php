<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        Schema::create('member_details', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->integer('m_id')->unsigned();  
            $table->string('task_' , 100);
            $table->string('update_' , 200);
            $table->integer('track_')->unsigned();  
            $table->string('screen_' , 200);
            $table->timestamps();
            $table->softDeletes();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_detail', function (Blueprint $table) {
            //
        });
    }
}
