<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrgenceToDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Adding 'urgence' column with enum values
            $table->enum('urgence', ['Élevé', 'Moyen', 'Bas'])->default('Moyen')->after('delivery_address');
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
            // Dropping the 'urgence' column if the migration is rolled back
            $table->dropColumn('urgence');
        });
    }
}
