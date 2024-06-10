<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_engine_technicentres', function (Blueprint $table) {
            $table->decimal('amount_du')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_engine_technicentres', function (Blueprint $table) {
            $table->dropColumn('amount_du');
        });
    }
};
