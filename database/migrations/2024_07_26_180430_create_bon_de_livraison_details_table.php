<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonDeLivraisonDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bon_de_livraison_details')) {
        Schema::create('bon_de_livraison_details', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->unsignedBigInteger('bon_de_livraison_id'); // Reference to the bon de livraison
            $table->unsignedBigInteger('article_id'); // Reference to the article
            $table->integer('quantity'); // Quantity delivered
            $table->decimal('unit_price', 8, 2); // Price per unit

            // Foreign key constraints
            $table->foreign('bon_de_livraison_id')->references('id')->on('bon_de_livraisons')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            // Timestamps
            $table->timestamps();
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
        Schema::table('bon_de_livraison_details', function (Blueprint $table) {
            $table->dropForeign(['bon_de_livraison_id']);
            $table->dropForeign(['article_id']);
        });

        Schema::dropIfExists('bon_de_livraison_details');
    }
}
