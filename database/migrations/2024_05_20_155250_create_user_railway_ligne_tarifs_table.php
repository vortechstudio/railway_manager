<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_ligne_tarifs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_tarif');
            $table->string('type_tarif');
            $table->integer('demande');
            $table->integer('offre');
            $table->decimal('price');
            $table->foreignId('user_railway_ligne_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_ligne_tarifs');
    }
};
