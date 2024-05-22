<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('railway_engine_shops', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->default(0);
            $table->string('money')->default('argent');
            $table->timestamps();

            $table->foreignId('railway_engine_id')
                ->constrained('railway_engines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_engine_shops');
    }
};
