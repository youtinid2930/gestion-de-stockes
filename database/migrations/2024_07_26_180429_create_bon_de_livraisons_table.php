<?php

// database/migrations/xxxx_xx_xx_create_bon_de_livraisons_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonDeLivraisonsTable extends Migration
{
    public function up()
    {
        Schema::create('bon_de_livraisons', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); // Exemple : Numéro du bon de livraison
            $table->date('date_livraison'); // Date de livraison
            $table->text('adresse_livraison'); // Adresse de livraison
            $table->foreignId('demande_id')->constrained('demandes')->onDelete('cascade'); // Clé étrangère pour Commande
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_de_livraisons');
    }
}
