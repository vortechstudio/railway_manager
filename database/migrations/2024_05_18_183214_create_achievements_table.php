<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('sector')->comment("Il s'agit du secteur du succès ou de sa catégorie");
            $table->string('level')->comment('niveau du succès (bronze,argent,or)');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('action')->comment("Type d'action qui déclenche le succès");
            $table->integer('goal')->comment('le but à atteindre pour déclencher le succès');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('achievements');
    }
};
