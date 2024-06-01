<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railway_engines', function (Blueprint $table) {
            $table->boolean('active')->default(false);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railway_engines', function (Blueprint $table) {
            //
        });
    }
};
