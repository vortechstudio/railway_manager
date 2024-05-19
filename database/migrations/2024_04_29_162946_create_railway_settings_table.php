<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('value');
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_settings');
    }
};
