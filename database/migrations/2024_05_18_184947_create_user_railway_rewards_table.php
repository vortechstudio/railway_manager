<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_rewards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->string('model');
            $table->unsignedBigInteger('model_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_rewards');
    }
};
