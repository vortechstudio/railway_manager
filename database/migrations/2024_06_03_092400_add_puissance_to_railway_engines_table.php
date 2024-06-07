<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->table('railway_engine_technicals', function (Blueprint $table) {
            $table->bigInteger('puissance')->nullable()->comment('Exprimé en Kw');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('railway_engine_technicals', function (Blueprint $table) {
            //
        });
    }
};
