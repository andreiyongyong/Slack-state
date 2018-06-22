<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResourceManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('resources', function (Blueprint $table){
            $table->renameColumn('title', 'project');
            $table->renameColumn('url', 'name');
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
        Schema::table('resources', function (Blueprint $table){
            $table->renameColumn('project', 'title');
            $table->renameColumn('name', 'url');
        });
    }
}
