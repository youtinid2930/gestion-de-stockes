<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            // Check if 'user_id' does not exist before adding it
            if (!Schema::hasColumn('companies', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Add the column
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add foreign key constraint
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            // Remove the 'user_id' column if it exists
            if (Schema::hasColumn('companies', 'user_id')) {
                $table->dropForeign(['user_id']); // Drop the foreign key constraint
                $table->dropColumn('user_id'); // Drop the column
            }
        });
    }
}
