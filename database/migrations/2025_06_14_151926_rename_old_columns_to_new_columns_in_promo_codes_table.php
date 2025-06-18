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
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->renameColumn('promo_code','name');
            $table->renameColumn('valid_from','start_date');
            $table->renameColumn('valid_until','end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->renameColumn('name','promo_code');
            $table->renameColumn('start_date','valid_from');
            $table->renameColumn('end_date','valid_until');
        });
    }
};
