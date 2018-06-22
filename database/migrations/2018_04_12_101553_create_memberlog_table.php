<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_logs', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->integer('userid')->unsigned();  
            $table->string('task' , 100);
            $table->string('url' , 100);
            $table->string('track_hour' , 20);
            $table->integer('validated')->unsigned();
            $table->string('penalty' , 200);
            $table->date('log_date');
            $table->string('summary' , 1000); 
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
        Schema::dropIfExists('member_logs');
    }
}
