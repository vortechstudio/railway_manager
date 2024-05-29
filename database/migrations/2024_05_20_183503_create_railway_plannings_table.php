<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_plannings', function (Blueprint $table) {
            $table->id();
            $table->string('number_travel')->nullable();
            $table->timestamp('date_depart');
            $table->string('status');
            $table->integer('retarded_time')->nullable();
            $table->integer('kilometer');
            $table->timestamp('date_arrived');

            $table->foreignId('user_railway_hub_id')
                ->references('id')
                ->on('user_railway_hubs')
                ->cascadeOnDelete();
            $table->foreignId('user_railway_ligne_id')
                ->references('id')
                ->on('user_railway_lignes')
                ->cascadeOnDelete();
            $table->foreignId('user_railway_engine_id')
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
        Schema::connection('railway')->dropIfExists('railway_plannings');
    }
};
