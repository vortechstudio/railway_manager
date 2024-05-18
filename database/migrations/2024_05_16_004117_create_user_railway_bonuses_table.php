<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('simulation')->default(0);
            $table->integer('audit_ext')->default(0);
            $table->integer('audit_int')->default(0);
            $table->foreignId('user_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_bonuses');
    }
};
