<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_achievements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('level');
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->bigInteger('goal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_achievements');
    }
};
