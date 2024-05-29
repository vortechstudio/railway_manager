<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_planning_passengers', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('nb_passengers');
            $table->foreignId('railway_planning_id')
                ->references('id')
                ->on('railway_plannings')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_planning_passengers');
    }
};
