<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacteurDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facteur_details', function (Blueprint $table) {
            $table->bigIncrements('id'); // Unique identifier for the detail
            $table->unsignedBigInteger('facteur_id'); // Reference to the invoice
            $table->unsignedBigInteger('article_id'); // Reference to the article
            $table->integer('quantity'); // Quantity billed

            // Foreign key constraints
            $table->foreign('facteur_id')->references('id')->on('facteurs')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facteur_details', function (Blueprint $table) {
            $table->dropForeign(['facteur_id']);
            $table->dropForeign(['article_id']);
        });

        Schema::dropIfExists('facteur_details');
    }
}
