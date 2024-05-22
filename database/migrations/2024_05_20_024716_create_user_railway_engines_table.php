<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_engines', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->integer('max_runtime')->default(0);
            $table->boolean('available')->default(false);
            $table->integer('use_percent')->default(0);
            $table->integer('older')->default(0);
            $table->timestamp('date_achat');
            $table->string('status')->default('in_delivery');

            $table->foreignId('user_id');
            $table->foreignId('railway_engine_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_engines');
    }
};
