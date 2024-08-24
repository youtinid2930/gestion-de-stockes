<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demande_details', function (Blueprint $table) {
            $table->integer('quantity_livree')->default(0)->after('quantity');
            $table->integer('quantity_restant')->default(0)->after('quantity_livree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_details', function (Blueprint $table) {
            $table->dropColumn('quantity_livree');
            $table->dropColumn('quantity_restant');
        });
    }
};
