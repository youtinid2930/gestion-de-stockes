<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepotIdToStockMovementsTable extends Migration
{
    public function up()
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->unsignedBigInteger('depot_id')->after('user_id');
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('cascade'); 
        });
    }

    public function down()
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropForeign(['depot_id']);
            $table->dropColumn('depot_id');
        });
    }
}
