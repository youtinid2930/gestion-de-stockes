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
    Schema::table('facteurs', function (Blueprint $table) {
        $table->decimal('tax_rate', 5, 2)->nullable(); // Add tax_rate
        $table->decimal('discount', 5, 2)->nullable(); // Add discount
        $table->text('terms_conditions')->nullable(); // Add terms_conditions
        $table->text('payment_instructions')->nullable(); // Add payment_instructions
        $table->text('bank_details')->nullable(); // Add bank_details
        $table->string('payment_terms')->nullable(); // Add payment_terms
    });
}

public function down()
{
    Schema::table('facteurs', function (Blueprint $table) {
        $table->dropColumn(['tax_rate', 'discount', 'terms_conditions', 'payment_instructions', 'bank_details', 'payment_terms']);
    });
}

};
