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

            $table->foreignId('achievement_id');
            $table->foreignId('reward_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('achievements_rewards');
    }
};
