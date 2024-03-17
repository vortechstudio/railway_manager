<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_hubs', function (Blueprint $table) {
            $table->id();
            $table->integer('price_base');
            $table->integer('taxe_hub_price');
            $table->boolean('active');
            $table->string('status');

            $table->foreignId('gare_id')
                ->constrained('railway_gares')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_hubs');
    }
};
