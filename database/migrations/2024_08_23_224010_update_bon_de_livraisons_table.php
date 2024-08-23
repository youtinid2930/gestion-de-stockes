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
            $table->dropColumn('adresse_livraison');
            $table->dropForeign(['demande_id']);
            $table->dropColumn('demande_id');
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
            $table->string('adresse_livraison'); 
            $table->unsignedBigInteger('demande_id'); 
            
            
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }
};
