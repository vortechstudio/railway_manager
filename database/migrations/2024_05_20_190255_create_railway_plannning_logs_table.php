<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_plannning_logs', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->foreignId('railway_planning_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_plannning_logs');
    }
};
