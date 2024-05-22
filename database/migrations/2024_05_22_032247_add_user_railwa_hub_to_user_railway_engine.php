<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_engines', function (Blueprint $table) {
            $table->foreignId('user_railway_hub_id');
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_engines', function (Blueprint $table) {
            $table->dropColumn('user_railway_hub_id');
        });
    }
};
