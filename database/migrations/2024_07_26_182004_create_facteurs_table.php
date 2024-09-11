<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('facteurs')) {
        Schema::create('facteurs', function (Blueprint $table) {
            $table->bigIncrements('id'); // Unique invoice identifier
            $table->string('invoice_number')->unique(); // Unique invoice number
            $table->date('issue_date'); // Invoice issue date
            $table->date('due_date'); // Invoice due date
            $table->unsignedBigInteger('fournisseur_id'); // Reference to the supplier
            $table->unsignedBigInteger('commande_id')->nullable(); // Reference to the order (optional)
            $table->decimal('total_amount', 10, 2); // Total amount of the invoice
            $table->decimal('amount_paid', 10, 2)->default(0); // Amount already paid
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending'); // Status of the invoice
            $table->text('comments')->nullable(); // Additional comments
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('set null');
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facteurs', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['order_id']);
        });

        Schema::dropIfExists('facteurs');
    }
}
