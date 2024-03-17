<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_banques', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('interest_min');
            $table->decimal('interest_max');
            $table->bigInteger('express_base')->comment('Emprunt express de base de la banque (ex: 5 000 000 €)');
            $table->bigInteger('public_base')->comment('Emprunt sur les marchés financiers de la banque (ex: 7 000 000€)');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_banques');
    }
};
