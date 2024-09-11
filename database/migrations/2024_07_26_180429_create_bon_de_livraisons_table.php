<?php

// database/migrations/xxxx_xx_xx_create_bon_de_livraisons_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonDeLivraisonsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bon_de_livraisons')) {
        Schema::create('bon_de_livraisons', function (Blueprint $table) {
            $table->id();
            $table->string('numero'); // Assurez-vous que le champ numero est bien défini
            $table->unsignedBigInteger('commande_id');
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->unsignedBigInteger('demande_id');
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->enum('status', ['En attente', 'Livree', 'Terminee']);

            $table->timestamps();
        });
    }     
    }

    public function down()
    {
        Schema::dropIfExists('bon_de_livraisons');
    }
}
