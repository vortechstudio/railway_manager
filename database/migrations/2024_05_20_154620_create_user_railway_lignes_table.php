<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_lignes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_achat');
            $table->integer('nb_depart_jour');
            $table->string('quai');
            $table->boolean('active')->default(false);

            $table->foreignId('user_railway_hub_id')
                ->references('id')
                ->on('user_railway_hubs')
                ->cascadeOnDelete();
            $table->foreignId('railway_ligne_id')
                ->references('id')
                ->on('railway_lignes')
                ->cascadeOnDelete();
            $table->foreignId('user_railway_engine_id')->nullable()
                ->references('id')
                ->on('user_railway_engines')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_lignes');
    }
};
