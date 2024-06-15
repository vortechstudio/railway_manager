<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_lignes', function (Blueprint $table) {
            $table->integer('level')->default(1);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_lignes', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
};
