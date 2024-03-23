<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_engine_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('achat');
            $table->boolean('in_reduction');
            $table->integer('percent_reduction')->nullable();
            $table->integer('maintenance')->nullable();
            $table->integer('location')->nullable();
            $table->timestamps();

            $table->foreignId('engine_id')
                ->constrained('railway_engines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_engine_prices');
    }
};
