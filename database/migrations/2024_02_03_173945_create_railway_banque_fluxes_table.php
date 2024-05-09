<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_banque_fluxes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->decimal('interest');

            $table->foreignId('railway_banque_id')
                ->constrained('railway_banques')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_banque_fluxes');
    }
};
