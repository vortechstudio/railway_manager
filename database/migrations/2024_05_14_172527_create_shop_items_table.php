<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('shop_items', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('section')->nullable();
                $table->text('description');
                $table->string('currency_type');
                $table->decimal('price', 16)->nullable();
                $table->enum('rarity', ['base', 'bronze', 'argent', 'or', 'legendary'])->default('base');
                $table->timestamp('disponibility_end_at')->nullable();
                $table->boolean('blocked')->default(false)->comment('Si blocked bloquer à un certain nombre d\'achat');
                $table->integer('blocked_max')->nullable();
                $table->integer('qte')->nullable();
                $table->boolean('recursive')->default(false)->comment('si true apparait de manière récursif dans la boutique');
                $table->string('recursive_periodicity')->nullable();
                $table->boolean('is_packager')->default(false)->comment('Si true disponible uniquement dans un package');
                $table->string('stripe_token')->nullable()->comment('Uniquement si le currency_type est reel format: price_xxx');
                $table->softDeletes();
                $table->foreignId('shop_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('shop_items');
    }
};
