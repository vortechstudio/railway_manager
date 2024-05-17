<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::connection('railway')->create('railway_engines', function (Blueprint $table) {
                $table->id();
                $table->uuid();
                $table->string('name');
                $table->string('type_transport');
                $table->string('type_train');
                $table->string('type_energy')->nullable();
                $table->time('duration_maintenance')->default('00:00:00');
                $table->boolean('active')->default(false);
                $table->boolean('in_shop')->default(false);
                $table->boolean('in_game')->default(true);
                $table->string('status');
                $table->softDeletes();
            });
    }

    public function down(): void
    {
            Schema::connection('railway')->dropIfExists('railway_engines');
    }
};
