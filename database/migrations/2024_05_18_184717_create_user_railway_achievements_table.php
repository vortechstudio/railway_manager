<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')
                ->references('id')
                ->on('achievements')
                ->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_achievements');
    }
};
