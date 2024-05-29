<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('designation');
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->foreignId('user_id');
            $table->string('model');
            $table->bigInteger('model_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_deliveries');
    }
};
