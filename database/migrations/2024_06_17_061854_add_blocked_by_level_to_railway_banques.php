<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('railway')->table('railway_banques', function (Blueprint $table) {
            $table->string('blocked_by')->nullable();
            $table->bigInteger('blocked_by_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('railway')->table('railway_banques', function (Blueprint $table) {
            $table->dropColumn(['blocked_by', 'blocked_by_id']);
        });
    }
};
