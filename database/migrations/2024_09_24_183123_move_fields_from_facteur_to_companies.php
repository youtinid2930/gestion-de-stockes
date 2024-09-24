<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveFieldsFromFacteurToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove fields from the `facteur` table
        Schema::table('facteurs', function (Blueprint $table) {
            $table->dropColumn('terms_conditions');
            $table->dropColumn('payment_instructions');
            $table->dropColumn('bank_details');
            $table->dropColumn('payment_terms');
        });

        // Add fields to the `companies` table
        Schema::table('companies', function (Blueprint $table) {
            $table->text('terms_conditions_commandes')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->text('bank_details')->nullable();
            $table->string('payment_terms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facteurs', function (Blueprint $table) {
            $table->text('terms_conditions')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->text('bank_details')->nullable();
            $table->string('payment_terms')->nullable();
        });

        // Remove fields from the `companies` table (if necessary for rollback)
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('terms_conditions_commandes');
            $table->dropColumn('payment_instructions');
            $table->dropColumn('bank_details');
            $table->dropColumn('payment_terms');
        });
    }
}

