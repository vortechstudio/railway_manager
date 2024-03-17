<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_lignes', function (Blueprint $table) {
            $table->id();
            $table->integer('price');
            $table->integer('distance')->nullable();
            $table->integer('time_min')->nullable();
            $table->boolean('active');
            $table->string('status')->nullable();
            $table->string('type');
            $table->softDeletes();

            $table->foreignId('start_gare_id')
                ->constrained('railway_gares')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('end_gare_id')
                ->constrained('railway_gares')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('hub_id')
                ->constrained('railway_hubs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_lignes');
    }
};
