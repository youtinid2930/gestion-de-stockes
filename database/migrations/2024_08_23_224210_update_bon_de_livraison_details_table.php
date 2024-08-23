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
        Schema::table('bon_de_livraison_details', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn('article_id');
            $table->dropColumn('quantity');
            $table->dropColumn('unit_price');
    
            $table->unsignedBigInteger('commande_id')->after('bon_de_livraison_id');
            $table->unsignedBigInteger('demande_id')->after('commande_id');
    
            
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bon_de_livraison_details', function (Blueprint $table) {
            $table->dropColumn('commande_id');
            $table->dropColumn('demande_id');
    
            $table->unsignedBigInteger('article_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
    
            
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }
};
