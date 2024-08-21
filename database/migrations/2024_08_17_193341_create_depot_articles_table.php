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
        if (!Schema::hasTable('depot_articles')) {
        Schema::create('depot_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('depot_id');
            $table->unsignedBigInteger('article_id');
            $table->integer('quantity');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
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
        Schema::table('depot_articles', function (Blueprint $table) {
            $table->dropForeign(['depot_id']);
            $table->dropForeign(['article_id']);
        });

        Schema::dropIfExists('depot_articles');
    }
};
