<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommandeIdToBonDeLivraisonsTable extends Migration
{
    public function up()
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->unsignedBigInteger('commande_id')->after('adresse_livraison');
            
            // Optionnel : Ajouter une contrainte de clé étrangère
            $table->foreign('commande_id')->references('id')->on('commandes');
        });
    }

    public function down()
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            // Optionnel : Supprimer la contrainte de clé étrangère
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
}

