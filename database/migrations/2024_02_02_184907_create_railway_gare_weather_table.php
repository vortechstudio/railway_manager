<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_gare_weather', function (Blueprint $table) {
            $table->id();
            $table->string('weather');
            $table->string('temperature');
            $table->dateTime('latest_update');

            $table->foreignId('gare_id')
                ->constrained('railway_gares')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_gare_weather');
    }
};
