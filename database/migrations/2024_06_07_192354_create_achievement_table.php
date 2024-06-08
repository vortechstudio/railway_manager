<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection('railway')->create('rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection('railway')->create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('required_value');
            $table->timestamps();
        });

        Schema::connection('railway')->create('achievement_condition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained();
            $table->foreignId('condition_id')->constrained();
            $table->timestamps();
        });

        Schema::connection('railway')->create('achievement_reward', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained();
            $table->foreignId('reward_id')->constrained();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('rewards');
        Schema::dropIfExists('conditions');
        Schema::dropIfExists('achievement_condition');
        Schema::dropIfExists('achievement_reward');
    }
};
