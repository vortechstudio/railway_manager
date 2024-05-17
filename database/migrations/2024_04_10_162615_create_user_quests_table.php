<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('user_quests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id');
                $table->foreignId('railway_quest_id')->constrained('railway_quests')->cascadeOnDelete()->cascadeOnUpdate();
                $table->timestamp('completed_at')->nullable();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('user_quests');
    }
};
