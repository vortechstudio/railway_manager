<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->table('user_railway_messages', function (Blueprint $table) {
                $table->string('reward_type')->nullable()->after('is_read');
                $table->bigInteger('reward_value')->nullable()->after('reward_type');
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->table('user_railway_messages', function (Blueprint $table) {
                $table->dropColumn('reward_type');
                $table->dropColumn('reward_value');
            });
    }
};
