<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('railway_level_reward_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('awarded_at');
            $table->string('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
