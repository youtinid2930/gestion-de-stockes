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
        $table->enum('urgence', ['Élevé', 'Moyen', 'Bas'])->nullable(); // Add urgence
        $table->text('terms_conditions')->nullable(); // Add terms_conditions
    });
}

public function down()
{
    Schema::table('demandes', function (Blueprint $table) {
        $table->dropColumn(['urgence', 'terms_conditions']);
    });
}
};
