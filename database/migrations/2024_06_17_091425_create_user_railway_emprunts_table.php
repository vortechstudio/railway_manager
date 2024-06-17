<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_emprunts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('number');
            $table->string('type_emprunt');
            $table->dateTime('date');
            $table->decimal('amount_emprunt');
            $table->float('taux_emprunt');
            $table->decimal('charge');
            $table->integer('duration');
            $table->decimal('amount_hebdo');
            $table->string('status');
            $table->foreignId('railway_banque_id');
            $table->foreignId('user_railway_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_emprunts');
    }
};
