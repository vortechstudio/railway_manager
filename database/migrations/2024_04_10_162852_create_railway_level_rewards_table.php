<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_level_rewards', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('type')->nullable();
                $table->string('action')->nullable();
                $table->integer('action_count')->default(0);
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_level_rewards');
    }
};
