<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('user_railways', function (Blueprint $table) {
            $table->integer('bank_note')->default(33);
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('user_railways', function (Blueprint $table) {
            $table->dropColumn('bank_note');
        });
    }
};
