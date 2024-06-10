<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_achievement_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('quantity');
            $table->foreignId('railway_achievement_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_achievement_rewards');
    }
};
