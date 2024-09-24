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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('registration_number')->nullable(); // Add registration_number
        });
    }
    
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('registration_number');
        });
    }
};
