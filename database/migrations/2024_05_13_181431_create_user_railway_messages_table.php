<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('message_id');
            $table->boolean('is_read')->default(false);
            $table->boolean('reward_collected')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_messages');
    }
};
