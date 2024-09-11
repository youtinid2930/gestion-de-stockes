<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityColumnsToBonDeLivraisonDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('bon_de_livraison_details', function (Blueprint $table) {
            $table->unsignedInteger('quantity_livree')->default(0); // Add column for delivered quantity
            $table->unsignedInteger('quantity_restant')->default(0); // Add column for remaining quantity
        });
    }

    public function down()
    {
        Schema::table('bon_de_livraison_details', function (Blueprint $table) {
            $table->dropColumn(['quantity_livree', 'quantity_restant']);
        });
    }
}

