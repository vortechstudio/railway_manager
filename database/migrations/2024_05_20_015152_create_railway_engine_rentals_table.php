<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_engine_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('railway_engine_id');
            $table->foreignId('railway_rental_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_engine_rentals');
    }
};
