<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_badge_rewards', function (Blueprint $table) {
                $table->id();
                $table->string('type');
                $table->string('value');

                $table->foreignId('badge_id')
                    ->constrained('railway_badges')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_badge_rewards');
    }
};
