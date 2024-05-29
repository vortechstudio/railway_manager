<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_railways', function (Blueprint $table) {
            $table->id();
            $table->boolean('installed')->default(false);
            $table->integer('level')->default(0);
            $table->bigInteger('xp')->default(0);
            $table->string('name_secretary')->nullable();
            $table->string('name_company')->nullable();
            $table->string('desc_company')->nullable();
            $table->decimal('argent', 64);
            $table->bigInteger('tpoint');
            $table->decimal('research', 64);
            $table->boolean('automated_planning')->default(false);
            $table->string('name_conseiller')->nullable();
            $table->string('stripe_id')->nullable();
            $table->foreignId('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railways');
    }
};
