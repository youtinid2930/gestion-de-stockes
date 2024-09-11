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
        Schema::table('users', function (Blueprint $table) {

            // Add the depot_id column after remember_token
            $table->unsignedBigInteger('depot_id')->nullable()->after('remember_token');

            $table->foreign('depot_id')->references('id')->on('depots')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            //Drop the depot_id column
            $table->dropForeign(['depot_id']);
            $table->dropColumn('depot_id');
        });
    }
};
