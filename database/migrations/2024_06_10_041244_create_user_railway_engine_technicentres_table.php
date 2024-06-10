<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_engine_technicentres', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('status');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('user_railway_engine_id');
            $table->foreignId('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_engine_technicentres');
    }
};
