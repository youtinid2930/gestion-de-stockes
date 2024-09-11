<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployerIdToDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Add employer_id after admin_id, nullable
            $table->foreignId('employer_id')->nullable()->after('admin_id')->constrained('employers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Drop the employer_id column
            $table->dropForeign(['employer_id']);
            $table->dropColumn('employer_id');
        });
    }
}
