<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('railway_incidents', function (Blueprint $table) {
            $table->decimal('amount_reparation')->default(0);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('railway_incidents', function (Blueprint $table) {
            $table->dropColumn('amount_reparation');
        });
    }
};
