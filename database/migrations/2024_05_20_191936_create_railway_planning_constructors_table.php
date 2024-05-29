<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_planning_constructors', function (Blueprint $table) {
            $table->id();
            $table->time('start_at');
            $table->time('end_at');
            $table->json('day_of_week');
            $table->boolean('repeat')->default(false);
            $table->timestamp('repeat_end_at');
            $table->foreignId('user_id');
            $table->foreignId('user_railway_engine_id')
                ->references('id')
                ->on('user_railway_engines')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_planning_constructors');
    }
};
