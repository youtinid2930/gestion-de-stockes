<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveTermsConditionsToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove 'terms_conditions' from the `demandes` table
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropColumn('terms_conditions');
        });

        // Remove 'terms_conditions' from the `bon_de_livraisons` table
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->dropColumn('terms_conditions');
        });

        // Add 'terms_conditions' to the `companies` table
        Schema::table('companies', function (Blueprint $table) {
            $table->text('terms_conditions_demandes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add 'terms_conditions' back to the `demandes` table
        Schema::table('demandes', function (Blueprint $table) {
            $table->text('terms_conditions')->nullable();
        });

        // Add 'terms_conditions' back to the `bon_de_livraisons` table
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->text('terms_conditions')->nullable();
        });

        // Remove 'terms_conditions' from the `companies` table
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('terms_conditions_demandes');
        });
    }
}

