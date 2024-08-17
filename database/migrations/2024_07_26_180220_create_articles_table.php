<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('name'); // Name of the article
            $table->text('description')->nullable(); // Description of the article
            $table->decimal('unit_price', 10, 2); // Price of the article (precision and scale)
            $table->unsignedInteger('stock'); // Stock quantity of the article
            $table->unsignedBigInteger('category_id'); // Foreign key to the category
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}



