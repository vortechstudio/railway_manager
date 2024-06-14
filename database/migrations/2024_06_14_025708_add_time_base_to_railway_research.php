<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('railway_researches', function (Blueprint $table) {
            $table->integer('time_base')->after('level_description')->default(0);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('railway_researches', function (Blueprint $table) {
            $table->dropColumn('time_base');
        });
    }
};
