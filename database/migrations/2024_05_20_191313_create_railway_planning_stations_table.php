<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_planning_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->timestamp('departure_at');
            $table->timestamp('arrival_at');
            $table->string('status')->default('init');
            $table->foreignId('railway_planning_id')
                ->references('id')
                ->on('railway_plannings')
                ->cascadeOnDelete();
            $table->foreignId('railway_ligne_station_id')
                ->references('id')
                ->on('railway_ligne_stations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_planning_stations');
    }
};
