<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('gestionnaire_id'); // Reference to the gestionnaire making the request
            $table->unsignedBigInteger('article_id'); // Reference to the article being requested
            $table->unsignedBigInteger('quantity'); // Quantity of the article requested
            $table->text('notes')->nullable(); // Optional notes or comments
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Status of the request
            $table->text('delivery_address'); // Delivery address
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraints
            $table->foreign('gestionnaire_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes');
    }
}
