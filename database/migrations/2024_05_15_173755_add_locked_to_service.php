<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('mysql')->table('services', function (Blueprint $table) {
                $table->boolean('locked')->default(false);
            });
    }

    public function down(): void
    {
            Schema::connection('mysql')->table('services', function (Blueprint $table) {
                $table->dropColumn('locked');
            });
    }
};
