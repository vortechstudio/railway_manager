<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('achieve_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('type_reward');
            $table->bigInteger('amount_reward');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('achieve_rewards');
    }
};
