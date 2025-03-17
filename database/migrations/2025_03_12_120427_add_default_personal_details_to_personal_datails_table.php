<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('personal_details', function (Blueprint $table) {
            $table->boolean('default_personal_details')-> nullable()->after('acceptance_of_the_invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_details', function (Blueprint $table) {
            $table->dropColumn('default_personal_details');
        });
    }
};
