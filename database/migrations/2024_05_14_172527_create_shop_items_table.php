<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shop_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('section')->nullable();
            $table->text('description');
            $table->string('currency_type');
            $table->integer('price')->nullable();
            $table->timestamp('disponibility_end_at')->nullable();
            $table->boolean('blocked')->default(false)->comment('Si blocked bloquer à un certain nombre d\'achat');
            $table->integer('blocked_max')->nullable();
            $table->boolean('recursive')->default(false)->comment('si true apparait de manière récursif dans la boutique');
            $table->string('recursive_periodicity')->nullable();
            $table->boolean('is_packager')->default(false)->comment('Si true disponible uniquement dans un package');
            $table->softDeletes();
            $table->foreignId('shop_category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_items');
    }
};
