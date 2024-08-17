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
            $table->string('numero'); // Assurez-vous que le champ numero est bien défini
            $table->date('date_livraison');
            $table->string('adresse_livraison');
            $table->unsignedBigInteger('commande_id');
            $table->timestamps();
        });    
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->unsignedBigInteger('commande_id'); // Ajoute la colonne
        });    
    }

    public function down()
    {
        Schema::dropIfExists('bon_de_livraisons');
    }
}
