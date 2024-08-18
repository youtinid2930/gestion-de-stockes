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
        Schema::table('articles', function (Blueprint $table) {
            // Add date de fabrication column
            $table->date('date_de_fabrication')->nullable();

            // Add date d'expiration column
            $table->date('date_d_expiration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            // Drop the date de fabrication column
            $table->dropColumn('date_de_fabrication');

            // Drop the date d'expiration column
            $table->dropColumn('date_d_expiration');
        });
    }
};
