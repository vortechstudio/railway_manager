<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->create('user_railway_emprunt_tables', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->decimal('amount', 16);
            $table->string('status');
            $table->foreignId('user_railway_emprunt_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->dropIfExists('user_railway_emprunt_tables');
    }
};
