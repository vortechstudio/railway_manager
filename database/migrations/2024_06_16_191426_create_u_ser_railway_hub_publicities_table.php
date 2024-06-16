<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_hub_publicities', function (Blueprint $table) {
            $table->id();
            $table->string('societe');
            $table->integer('nb_slot');
            $table->decimal('amount_invest');
            $table->decimal('ca_daily');
            $table->integer('nb_day_contract');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('user_railway_hub_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_hub_publicities');
    }
};
