<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->create('shop_packages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->longText('description');
                $table->string('currency_type');
                $table->string('price');
                $table->softDeletes();

                $table->foreignId('shop_category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->dropIfExists('shop_packages');
    }
};
