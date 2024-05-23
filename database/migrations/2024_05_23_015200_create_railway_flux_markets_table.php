<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_flux_markets', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_flux_engine', 16);
            $table->decimal('flux_engine', 16);
            $table->decimal('amount_flux_hub', 16);
            $table->decimal('flux_hub', 16);
            $table->decimal('amount_flux_ligne', 16);
            $table->decimal('flux_ligne', 16);
            $table->dateTime('date');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_flux_markets');
    }
};
