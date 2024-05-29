<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('railway_incidents', function (Blueprint $table) {
            $table->id();
            $table->string('type_incident');
            $table->integer('niveau');
            $table->boolean('closed')->default(false);
            $table->string('designation');
            $table->string('note');
            $table->timestamps();

            $table->foreignId('user_id');
            $table->foreignId('railway_planning_id')
                ->references('id')
                ->on('railway_plannings')
                ->cascadeOnDelete();
            $table->foreignId('user_railway_engine_id')
                ->references('id')
                ->on('user_railway_engines')
                ->cascadeOnDelete();
            $table->foreignId('user_railway_hub_id')
                ->references('id')
                ->on('user_railway_hubs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('railway_incidents');
    }
};
