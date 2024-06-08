<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_achievements', function (Blueprint $table) {
            $table->id();
            $table->integer('progress')->default(0);
            $table->boolean('completed')->default(false);
            $table->dateTime('completed_at')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('railway_achievement_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_achievements');
    }
};
