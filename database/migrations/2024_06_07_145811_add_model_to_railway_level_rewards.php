<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('railway')->table('railway_level_rewards', function (Blueprint $table) {
            $table->string('model')->nullable();
            $table->bigInteger('model_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('railway')->table('railway_level_rewards', function (Blueprint $table) {
            $table->dropColumn(['model', 'model_id']);
        });
    }
};
