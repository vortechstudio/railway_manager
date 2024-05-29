<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('achievements_rewards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('achievement_id')
                ->references('id')
                ->on('achievements')
                ->cascadeOnDelete();
            $table->foreignId('reward_id')
                ->references('id')
                ->on('achieve_rewards')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('achievements_rewards');
    }
};
