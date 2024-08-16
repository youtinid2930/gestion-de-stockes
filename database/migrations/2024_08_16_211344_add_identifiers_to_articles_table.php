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
            $table->string('sku')->nullable()->after('location');  // SKU
            $table->string('serial_number')->unique()->nullable()->after('sku');  // Serial Number
            $table->string('batch_number')->nullable()->after('serial_number');   // Batch Number
            $table->string('combined_code')->unique()->nullable()->after('batch_number');  // Combined Code
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
            $table->dropColumn(['sku', 'serial_number', 'batch_number', 'combined_code']);
        });
    }
};
