<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwsinstanceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awsinstance', function (Blueprint $table) {
            $table->increments('id' , true);
            $table->integer('aws_mid')->unsigned();  
            $table->string('purpose' , 100);
            $table->string('ip' );
            $table->string('country');
            $table->string('pem_file'); 
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
        //
    }
}
