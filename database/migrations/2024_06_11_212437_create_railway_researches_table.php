<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_researches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('cost');
            $table->integer('level');
            $table->text('level_description')->nullable();
            $table->foreignId('railway_research_category_id');
            $table->foreignId('parent_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_researches');
    }
};
