<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_hubs', function (Blueprint $table) {
                $table->id();
                $table->integer('price_base');
                $table->integer('taxe_hub_price');
                $table->boolean('active');
                $table->string('status');

                $table->foreignId('railway_gare_id')
                    ->constrained('railway_gares')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_hubs');
    }
};
