<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_companies', function (Blueprint $table) {
            $table->id();
            $table->integer('distraction')->default(0);
            $table->integer('tarification')->default(0);
            $table->integer('ponctualite')->default(0);
            $table->integer('securite')->default(0);
            $table->integer('confort')->default(0);
            $table->integer('rent_aux')->default(0);
            $table->integer('frais')->default(0);
            $table->integer('livraison')->default(1);
            $table->decimal('valorisation', 16)->default(0);
            $table->decimal('benefice_hebdo_travel', 16)->default(0);
            $table->decimal('mass_salarial', 16)->default(0);
            $table->decimal('treso_structurel', 16)->default(0);
            $table->decimal('last_impot', 16)->default(0);
            $table->decimal('location_mensual_fee', 16)->default(0);
            $table->decimal('remb_mensual', 16)->default(0);
            $table->integer('subvention')->default(0);
            $table->decimal('rate_research', 16)->default(1);
            $table->decimal('credit_impot', 16)->default(0);
            $table->decimal('research_coast_base', 16)->default(0);
            $table->decimal('research_coast_max', 16)->default(25000);
            $table->foreignId('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_companies');
    }
};
