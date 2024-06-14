<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_companies', function (Blueprint $table) {
            $table->boolean('access_fret')->default(false);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_companies', function (Blueprint $table) {
            $table->dropColumn('access_fret');
        });
    }
};
