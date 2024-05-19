<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->table('railway_quests', function (Blueprint $table) {
                $table->string('action');
                $table->integer('action_count');
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->table('railway_quests', function (Blueprint $table) {
                $table->dropColumn(['action', 'action_count']);
            });
    }
};
