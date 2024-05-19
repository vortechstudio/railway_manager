<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_engine_technicals', function (Blueprint $table) {
                $table->id();
                $table->string('essieux');
                $table->integer('velocity');
                $table->string('motor');
                $table->string('marchandise')->default('none');
                $table->integer('nb_marchandise')->nullable();
                $table->integer('nb_wagon')->nullable();

                $table->foreignId('railway_engine_id')
                    ->constrained('railway_engines')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_engine_technicals');
    }
};
