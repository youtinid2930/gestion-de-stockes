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
    Schema::table('bon_de_livraisons', function (Blueprint $table) {
        $table->text('terms_conditions')->nullable(); // Add terms_conditions
    });
}

public function down()
{
    Schema::table('bon_de_livraisons', function (Blueprint $table) {
        $table->dropColumn('terms_conditions');
    });
}

};
