<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_hubs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_achat');
            $table->decimal('km_ligne', 16);
            $table->boolean('active')->default(false);
            $table->boolean('commerce')->default(false);
            $table->boolean('publicity')->default(false);
            $table->boolean('parking')->default(false);
            $table->integer('commerce_limit')->default(0);
            $table->integer('publicity_limit')->default(0);
            $table->integer('parking_limit')->default(0);
            $table->integer('commerce_actual')->default(0);
            $table->integer('publicity_actual')->default(0);
            $table->integer('parking_actual')->default(0);
            $table->integer('ligne_limit')->default(0);
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreignId('railway_hub_id')
                ->references('id')
                ->on('railway_hubs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_hubs');
    }
};
