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
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            
            //$table->enum('status', ['en attente', 'livree', 'terminee'])->after('demande_id'); 

            $table->dropForeign(['commande_id']);

            $table->dropColumn('commande_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            
            //$table->dropColumn('status');

            
            $table->unsignedBigInteger('commande_id')->nullable()->after('adresse_livraison');
            
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
        });
    }
};
