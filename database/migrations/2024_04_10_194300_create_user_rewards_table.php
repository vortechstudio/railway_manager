<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('railway_level_reward_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('awarded_at');
            $table->string('status');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_rewards');
    }
};
