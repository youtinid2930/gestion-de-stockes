<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeDetailsTable extends Migration
{

    public function up()
    {
        Schema::create('demande_details', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('demande_id'); // Foreign key to demandes
            $table->unsignedBigInteger('article_id'); // Foreign key to articles
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraints
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('demande_details');
    }
}
