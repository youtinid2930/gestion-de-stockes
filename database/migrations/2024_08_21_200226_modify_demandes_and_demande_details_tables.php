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
        // Remove 'quantite' column from 'demandes' table
        
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });

        // Add 'quantite' column to 'demande_details' table
        Schema::table('demande_details', function (Blueprint $table) {
            $table->integer('quantity')->after('article_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add 'quantite' column back to 'demandes' table
        Schema::table('demandes', function (Blueprint $table) {
            $table->integer('quantity')->nullable();
        });

        // Remove 'quantite' column from 'demande_details' table
        Schema::table('demande_details', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
