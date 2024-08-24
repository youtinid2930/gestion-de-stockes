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
        Schema::table('demandes', function (Blueprint $table) {
            // Ajout du nouveau statut dans l'énumération
            DB::statement("ALTER TABLE demandes MODIFY COLUMN status ENUM('En attente','En cours de traitement','Livrée_partiellement','Livrée','Complétée')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            DB::statement("ALTER TABLE demandes MODIFY COLUMN status ENUM('En attente','En cours de traitement','Livrée','Complétée')");
        });
    }
};
