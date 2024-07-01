<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_lignes', function (Blueprint $table) {
            $table->integer('min_passengers')->nullable();
            $table->integer('max_passengers')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_lignes', function (Blueprint $table) {
            $table->dropColumn(['min_passengers', 'max_passengers']);
        });
    }
};
