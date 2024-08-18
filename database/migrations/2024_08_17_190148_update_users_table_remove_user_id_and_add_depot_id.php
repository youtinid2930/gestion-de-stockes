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
            // Drop the role_id column
            $table->dropForeign(['id_role']);
            $table->dropColumn('id_role');

            // Add the depot_id column after remember_token
            $table->unsignedBigInteger('depot_id')->after('remember_token');

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
            // Re-add the user_id column
            $table->unsignedBigInteger('id_role')->nullable();
            $table->foreign('id_role')->references('id')->on('roles');

            // Drop the depot_id column
            $table->dropForeign(['depot_id']);
            $table->dropColumn('depot_id');
        });
    }
};
