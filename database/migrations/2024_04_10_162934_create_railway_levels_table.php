<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_levels', function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->bigInteger('exp_required')->default(0);
                $table->foreignId('railway_level_reward_id')->constrained('railway_level_rewards')->cascadeOnDelete()->cascadeOnUpdate();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_levels');
    }
};
