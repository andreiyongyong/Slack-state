<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFieldsOnMarket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        $this->up_biddate();
        $this->up_status();
    }


    private function up_biddate() {
        $results = DB::table('market')->select('id', 'bid_date')->get();
        foreach ($results as $result) {
            $b_date = DateTime::createFromFormat('Y-m-d', $result->bid_date);
            $result->bid_date = $b_date->format('d');
        }
        Schema::table('market', function (Blueprint $table) {
            $table->dropColumn('bid_date');
        });
        Schema::table('market', function (Blueprint $table) {
            $table->integer('bid_date');
        });
        foreach ($results as $result){
            DB::table('market')
                ->where('id', $result->id)
                ->update(['bid_date' => $result->bid_date]);
        }
    }

    private function up_status() {
        Schema::table('market', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('market', function($table) {
            $table->enum('status', ['pending', 'updated', 'done']);
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
            $table->dropColumn('bid_date');
            $table->date('bid_date');
        });
    }
}
