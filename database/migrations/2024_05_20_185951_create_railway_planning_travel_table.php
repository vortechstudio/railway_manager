<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_planning_travel', function (Blueprint $table) {
            $table->id();
            $table->decimal('ca_billetterie');
            $table->decimal('ca_other');
            $table->decimal('fee_electrique');
            $table->decimal('fee_gasoil');
            $table->decimal('fee_other');
            $table->foreignId('railway_planning_id')
                ->references('id')
                ->on('railway_plannings')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_planning_travel');
    }
};
