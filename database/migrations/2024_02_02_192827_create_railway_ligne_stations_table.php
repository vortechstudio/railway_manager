<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_ligne_stations', function (Blueprint $table) {
                $table->id();
                $table->integer('time');
                $table->decimal('distance');

                $table->foreignId('railway_gare_id')
                    ->constrained('railway_gares')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();

                $table->foreignId('railway_ligne_id')
                    ->constrained('railway_lignes')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_ligne_stations');
    }
};
