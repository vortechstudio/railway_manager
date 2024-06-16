<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_hub_commerces', function (Blueprint $table) {
            $table->id();
            $table->string('societe');
            $table->integer('nb_slot_commerce');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->foreignId('user_railway_hub_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_hub_commerces');
    }
};
