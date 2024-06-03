<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('mysql')->table('shop_items', function (Blueprint $table) {
            $table->string('model')->nullable();
            $table->bigInteger('model_id')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection('mysql')->table('shop_items', function (Blueprint $table) {
            $table->dropColumn(['model', 'model_id']);
        });
    }
};
